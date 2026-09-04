import { Editor } from '@tiptap/core';
import StarterKit from '@tiptap/starter-kit';
import Underline from '@tiptap/extension-underline';
import TextAlign from '@tiptap/extension-text-align';
import Link from '@tiptap/extension-link';
import Image from '@tiptap/extension-image';
import Youtube from '@tiptap/extension-youtube';
import { Table } from '@tiptap/extension-table';
import { TableRow } from '@tiptap/extension-table-row';
import { TableHeader } from '@tiptap/extension-table-header';
import { TableCell } from '@tiptap/extension-table-cell';
import { Color } from '@tiptap/extension-color';
import { TextStyle } from '@tiptap/extension-text-style';
import TaskList from '@tiptap/extension-task-list';
import TaskItem from '@tiptap/extension-task-item';

// Custom Extension for Table Cell/Row Background Colors
const CustomTableCell = TableCell.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            backgroundColor: {
                default: null,
                parseHTML: element => element.style.backgroundColor || null,
                renderHTML: attributes => {
                    if (!attributes.backgroundColor) return {};
                    return { style: `background-color: ${attributes.backgroundColor}` };
                },
            },
        };
    },
});

const CustomTableHeader = TableHeader.extend({
    addAttributes() {
        return {
            ...this.parent?.(),
            backgroundColor: {
                default: null,
                parseHTML: element => element.style.backgroundColor || null,
                renderHTML: attributes => {
                    if (!attributes.backgroundColor) return {};
                    return { style: `background-color: ${attributes.backgroundColor}` };
                },
            },
        };
    },
});

// Custom Extension for Accordion
import { Node, mergeAttributes } from '@tiptap/core';

// AccordionTitle: the <summary> tag — NOT in 'block' group so it only lives inside Accordion
const AccordionTitle = Node.create({
    name: 'accordionTitle',
    // intentionally no group — only used inside Accordion node
    content: 'inline*',
    parseHTML() {
        return [{ tag: 'summary' }];
    },
    renderHTML({ HTMLAttributes }) {
        return ['summary', mergeAttributes(HTMLAttributes), 0];
    },
});

// Accordion: the <details> tag, accepts one AccordionTitle then any block content (table, paragraph, etc.)
// We always render with `open` so the table inside is VISIBLE and EDITABLE in the editor.
// On the frontend, a small JS snippet will close them by default.
const Accordion = Node.create({
    name: 'accordion',
    group: 'block',
    content: 'accordionTitle block+',
    parseHTML() {
        // Match both <details> and <details open>
        return [{ tag: 'details' }];
    },
    renderHTML({ HTMLAttributes }) {
        // Always open in editor so content is accessible
        return ['details', mergeAttributes({ open: '' }, HTMLAttributes), 0];
    },
});

document.addEventListener('DOMContentLoaded', () => {
    const wrappers = document.querySelectorAll('.tiptap-wrapper');

    wrappers.forEach(wrapper => {
        const container = wrapper.querySelector('.tiptap-editor-content');
        const hiddenInput = wrapper.querySelector('.tiptap-hidden-input');
        const toolbar = wrapper.querySelector('.tiptap-toolbar');

        if (!container || !hiddenInput) return;

        const editor = new Editor({
            element: container,
            extensions: [
                StarterKit,
                Underline,
                TextAlign.configure({ types: ['heading', 'paragraph'] }),
                Link.configure({ openOnClick: false }),
                Image.configure({ inline: true }),
                Youtube,
                Table.configure({ resizable: true }),
                TableRow,
                CustomTableHeader,
                CustomTableCell,
                TextStyle,
                Color,
                TaskList,
                TaskItem.configure({ nested: true }),
                Accordion,
                AccordionTitle,
            ],
            content: hiddenInput.value,
            onUpdate: ({ editor }) => {
                hiddenInput.value = editor.getHTML();
                updateActiveStates(editor, toolbar);
            },
            onSelectionUpdate: ({ editor }) => {
                updateActiveStates(editor, toolbar);
                toggleTableActions(editor, wrapper);
            },
        });

        // Setup Toolbar Listeners
        setupToolbar(editor, wrapper);
    });
});

function updateActiveStates(editor, toolbar) {
    if (!toolbar) return;
    
    // Simple formats
    const actions = ['bold', 'italic', 'underline', 'strike', 'blockquote', 'bullet-list', 'ordered-list', 'task-list'];
    actions.forEach(action => {
        const btn = toolbar.querySelector(`[data-tiptap-action="${action}"]`);
        if (btn) {
            // map action to internal name if needed
            let cmd = action;
            if(action === 'bullet-list') cmd = 'bulletList';
            if(action === 'ordered-list') cmd = 'orderedList';
            if(action === 'task-list') cmd = 'taskList';
            
            btn.classList.toggle('active', editor.isActive(cmd));
        }
    });

    // Alignments
    ['left', 'center', 'right', 'justify'].forEach(align => {
        const btn = toolbar.querySelector(`[data-tiptap-action="align-${align}"]`);
        if (btn) btn.classList.toggle('active', editor.isActive({ textAlign: align }));
    });
}

function toggleTableActions(editor, wrapper) {
    const tableActions = wrapper.querySelector('.table-actions');
    if (tableActions) {
        if (editor.isActive('table')) {
            tableActions.classList.remove('d-none');
            tableActions.classList.add('d-flex');
        } else {
            tableActions.classList.add('d-none');
            tableActions.classList.remove('d-flex');
        }
    }
}

function setupToolbar(editor, wrapper) {
    const toolbar = wrapper.querySelector('.tiptap-toolbar');
    if (!toolbar) return;

    toolbar.addEventListener('click', e => {
        const btn = e.target.closest('[data-tiptap-action]');
        if (!btn) return;

        const action = btn.getAttribute('data-tiptap-action');
        e.preventDefault();

        switch (action) {
            case 'undo': editor.chain().focus().undo().run(); break;
            case 'redo': editor.chain().focus().redo().run(); break;
            case 'bold': editor.chain().focus().toggleBold().run(); break;
            case 'italic': editor.chain().focus().toggleItalic().run(); break;
            case 'underline': editor.chain().focus().toggleUnderline().run(); break;
            case 'strike': editor.chain().focus().toggleStrike().run(); break;
            case 'paragraph': editor.chain().focus().setParagraph().run(); break;
            case 'heading': 
                const level = parseInt(btn.getAttribute('data-level'));
                editor.chain().focus().toggleHeading({ level }).run(); 
                break;
            case 'align-left': editor.chain().focus().setTextAlign('left').run(); break;
            case 'align-center': editor.chain().focus().setTextAlign('center').run(); break;
            case 'align-right': editor.chain().focus().setTextAlign('right').run(); break;
            case 'align-justify': editor.chain().focus().setTextAlign('justify').run(); break;
            case 'bullet-list': editor.chain().focus().toggleBulletList().run(); break;
            case 'ordered-list': editor.chain().focus().toggleOrderedList().run(); break;
            case 'task-list': editor.chain().focus().toggleTaskList().run(); break;
            case 'blockquote': editor.chain().focus().toggleBlockquote().run(); break;
            case 'horizontal-rule': editor.chain().focus().setHorizontalRule().run(); break;
            case 'link':
                const prevUrl = editor.getAttributes('link').href || '';
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Sisipkan Tautan (Link)',
                        input: 'text',
                        inputLabel: 'Masukkan URL Tautan',
                        inputValue: prevUrl,
                        inputPlaceholder: 'https://example.com',
                        showCancelButton: true,
                        showDenyButton: !!prevUrl,
                        denyButtonText: 'Hapus Tautan',
                        denyButtonColor: '#dc3545',
                        confirmButtonText: 'Simpan Tautan',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#0f172a',
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            let url = result.value.trim();
                            if (!/^https?:\/\//i.test(url) && !url.startsWith('/') && !url.startsWith('#')) {
                                url = 'https://' + url;
                            }
                            editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
                        } else if (result.isDenied) {
                            editor.chain().focus().extendMarkRange('link').unsetLink().run();
                        }
                    });
                } else {
                    const url = window.prompt('URL:', prevUrl);
                    if (url === null) return;
                    if (url === '') {
                        editor.chain().focus().extendMarkRange('link').unsetLink().run();
                    } else {
                        editor.chain().focus().extendMarkRange('link').setLink({ href: url }).run();
                    }
                }
                break;
            case 'image':
                uploadImagePrompt(editor);
                break;
            case 'pdf':
                uploadPdfPrompt(editor);
                break;
            case 'youtube':
                if (typeof Swal !== 'undefined') {
                    Swal.fire({
                        title: 'Sisipkan Video YouTube',
                        input: 'text',
                        inputLabel: 'Masukkan Link / URL Video YouTube',
                        inputPlaceholder: 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                        showCancelButton: true,
                        confirmButtonText: 'Sisipkan Video',
                        cancelButtonText: 'Batal',
                        confirmButtonColor: '#0f172a',
                        inputValidator: (value) => {
                            if (!value || !value.trim()) {
                                return 'URL video YouTube tidak boleh kosong!';
                            }
                        }
                    }).then((result) => {
                        if (result.isConfirmed && result.value) {
                            const url = result.value.trim();
                            editor.chain().focus().setYoutubeVideo({ src: url }).run();
                        }
                    });
                } else {
                    const yt = window.prompt('YouTube Video URL:');
                    if (yt) editor.chain().focus().setYoutubeVideo({ src: yt.trim() }).run();
                }
                break;
            
            // Table Core
            case 'table':
                editor.chain().focus().insertTable({ rows: 3, cols: 3, withHeaderRow: true }).run();
                break;
            case 'table-row-before': editor.chain().focus().addRowBefore().run(); break;
            case 'table-row-after': editor.chain().focus().addRowAfter().run(); break;
            case 'table-delete-row': editor.chain().focus().deleteRow().run(); break;
            case 'table-col-before': editor.chain().focus().addColumnBefore().run(); break;
            case 'table-col-after': editor.chain().focus().addColumnAfter().run(); break;
            case 'table-delete-col': editor.chain().focus().deleteColumn().run(); break;
            case 'table-merge-cells': editor.chain().focus().mergeCells().run(); break;
            case 'table-split-cell': editor.chain().focus().splitCell().run(); break;
            case 'table-delete': editor.chain().focus().deleteTable().run(); break;
            case 'table-bg':
                const color = btn.getAttribute('data-color');
                editor.chain().focus().setCellAttribute('backgroundColor', color).run();
                break;
                
            // Custom Accordion — judul (summary) + tabel langsung di bawahnya
            case 'accordion':
                editor.chain().focus().insertContent({
                    type: 'accordion',
                    content: [
                        {
                            type: 'accordionTitle',
                            content: [{ type: 'text', text: 'Judul Accordion' }],
                        },
                        {
                            type: 'table',
                            content: [
                                {
                                    type: 'tableRow',
                                    content: [
                                        { type: 'tableHeader', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'Kolom 1' }] }] },
                                        { type: 'tableHeader', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'Kolom 2' }] }] },
                                        { type: 'tableHeader', content: [{ type: 'paragraph', content: [{ type: 'text', text: 'Kolom 3' }] }] },
                                    ],
                                },
                                {
                                    type: 'tableRow',
                                    content: [
                                        { type: 'tableCell', content: [{ type: 'paragraph' }] },
                                        { type: 'tableCell', content: [{ type: 'paragraph' }] },
                                        { type: 'tableCell', content: [{ type: 'paragraph' }] },
                                    ],
                                },
                                {
                                    type: 'tableRow',
                                    content: [
                                        { type: 'tableCell', content: [{ type: 'paragraph' }] },
                                        { type: 'tableCell', content: [{ type: 'paragraph' }] },
                                        { type: 'tableCell', content: [{ type: 'paragraph' }] },
                                    ],
                                },
                            ],
                        },
                    ],
                }).run();
                break;

            // Fullscreen
            case 'fullscreen':
                wrapper.classList.toggle('fullscreen');
                break;
        }
    });
}

function uploadImagePrompt(editor) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'image/jpeg, image/png, image/webp, image/gif';
    
    input.onchange = async () => {
        if (input.files.length > 0) {
            const file = input.files[0];
            const formData = new FormData();
            formData.append('file', file);

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Mengunggah Gambar...',
                    text: 'Mohon tunggu sejenak',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
            }

            try {
                const res = await fetch('/editor/upload-image', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token },
                    body: formData
                });
                
                const data = await res.json();
                if (data.location) {
                    if (typeof Swal !== 'undefined') Swal.close();
                    editor.chain().focus().setImage({ src: data.location }).run();
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Gagal!', data.error || 'Gagal mengunggah gambar', 'error');
                    } else {
                        alert('Gagal mengunggah gambar: ' + (data.error || 'Unknown error'));
                    }
                }
            } catch (err) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error!', 'Kesalahan jaringan saat mengunggah gambar', 'error');
                } else {
                    alert('Kesalahan jaringan.');
                }
            }
        }
    };
    
    input.click();
}

function uploadPdfPrompt(editor) {
    const input = document.createElement('input');
    input.type = 'file';
    input.accept = 'application/pdf';
    
    input.onchange = async () => {
        if (input.files.length > 0) {
            const file = input.files[0];
            const formData = new FormData();
            formData.append('file', file);

            const token = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
            
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: 'Mengunggah PDF...',
                    text: 'Mohon tunggu sejenak',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });
            }

            try {
                const res = await fetch('/editor/upload-pdf', {
                    method: 'POST',
                    headers: { 'X-CSRF-TOKEN': token },
                    body: formData
                });
                
                const data = await res.json();
                if (data.location) {
                    if (typeof Swal !== 'undefined') Swal.close();
                    editor.chain().focus().insertContent(`
                        <a href="${data.location}" class="tiptap-pdf-embed" target="_blank" rel="noopener noreferrer">
                            <div class="tiptap-pdf-info">
                                <div class="tiptap-pdf-icon"><i class="bi bi-file-earmark-pdf-fill"></i></div>
                                <div class="min-w-0">
                                    <div class="fw-bold text-truncate mb-0 fs-7">${file.name}</div>
                                    <small class="text-body-secondary fs-8">Dokumen PDF Resmi</small>
                                </div>
                            </div>
                            <div class="tiptap-pdf-action">
                                <i class="bi bi-download"></i> Unduh PDF
                            </div>
                        </a><p></p>
                    `).run();
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire('Gagal!', data.error || 'Gagal mengunggah PDF', 'error');
                    } else {
                        alert('Gagal mengunggah PDF: ' + (data.error || 'Unknown error'));
                    }
                }
            } catch (err) {
                if (typeof Swal !== 'undefined') {
                    Swal.fire('Error!', 'Kesalahan jaringan saat mengunggah PDF', 'error');
                } else {
                    alert('Kesalahan jaringan.');
                }
            }
        }
    };
    
    input.click();
}


