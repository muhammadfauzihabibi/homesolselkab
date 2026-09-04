@props(['name', 'id' => 'konten', 'value' => ''])

<div class="tiptap-wrapper border rounded-4 bg-white mb-3 shadow-sm d-flex flex-column" data-bs-theme="light">
    <!-- Toolbar -->
    <div class="tiptap-toolbar p-2 border-bottom d-flex flex-wrap gap-1 bg-light rounded-top-4" style="position: sticky; top: 0; z-index: 10;">
        
        <!-- Undo / Redo -->
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="undo" title="Undo"><i class="bi bi-arrow-counterclockwise"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="redo" title="Redo"><i class="bi bi-arrow-clockwise"></i></button>
        </div>

        <!-- Format Text -->
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="bold" title="Bold"><i class="bi bi-type-bold"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="italic" title="Italic"><i class="bi bi-type-italic"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="underline" title="Underline"><i class="bi bi-type-underline"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="strike" title="Strikethrough"><i class="bi bi-type-strikethrough"></i></button>
        </div>

        <!-- Headings -->
        <div class="dropdown">
            <button class="btn btn-sm btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                <i class="bi bi-type-h1"></i> Heading
            </button>
            <ul class="dropdown-menu">
                <li><a class="dropdown-item" href="#" data-tiptap-action="heading" data-level="1">Heading 1</a></li>
                <li><a class="dropdown-item" href="#" data-tiptap-action="heading" data-level="2">Heading 2</a></li>
                <li><a class="dropdown-item" href="#" data-tiptap-action="heading" data-level="3">Heading 3</a></li>
                <li><a class="dropdown-item" href="#" data-tiptap-action="heading" data-level="4">Heading 4</a></li>
                <li><a class="dropdown-item" href="#" data-tiptap-action="heading" data-level="5">Heading 5</a></li>
                <li><a class="dropdown-item" href="#" data-tiptap-action="heading" data-level="6">Heading 6</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" data-tiptap-action="paragraph">Paragraph</a></li>
            </ul>
        </div>

        <!-- Alignment -->
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="align-left" title="Align Left"><i class="bi bi-text-left"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="align-center" title="Align Center"><i class="bi bi-text-center"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="align-right" title="Align Right"><i class="bi bi-text-right"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="align-justify" title="Justify"><i class="bi bi-justify"></i></button>
        </div>

        <!-- Lists -->
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="bullet-list" title="Bullet List"><i class="bi bi-list-ul"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="ordered-list" title="Ordered List"><i class="bi bi-list-ol"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="task-list" title="Task List"><i class="bi bi-ui-checks"></i></button>
        </div>
        
        <!-- Elements -->
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="blockquote" title="Blockquote"><i class="bi bi-quote"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="horizontal-rule" title="Horizontal Rule"><i class="bi bi-hr"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="link" title="Link"><i class="bi bi-link-45deg"></i></button>
        </div>

        <!-- Insert Media -->
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="image" title="Insert Image"><i class="bi bi-image"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="youtube" title="Insert YouTube"><i class="bi bi-youtube"></i></button>
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="pdf" title="Insert PDF Document"><i class="bi bi-file-earmark-pdf"></i></button>
        </div>

        <!-- Table Core -->
        <div class="btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="table" title="Insert Table"><i class="bi bi-table"></i></button>
        </div>

        <!-- Table Actions (Hidden by default, shown when cursor in table) -->
        <div class="table-actions d-none gap-1 border-start ps-2 ms-1">
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary" data-tiptap-action="table-row-before" title="Add Row Above"><i class="bi bi-arrow-bar-up"></i></button>
                <button type="button" class="btn btn-outline-primary" data-tiptap-action="table-row-after" title="Add Row Below"><i class="bi bi-arrow-bar-down"></i></button>
                <button type="button" class="btn btn-outline-danger" data-tiptap-action="table-delete-row" title="Delete Row"><i class="bi bi-trash"></i></button>
            </div>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-primary" data-tiptap-action="table-col-before" title="Add Col Left"><i class="bi bi-arrow-bar-left"></i></button>
                <button type="button" class="btn btn-outline-primary" data-tiptap-action="table-col-after" title="Add Col Right"><i class="bi bi-arrow-bar-right"></i></button>
                <button type="button" class="btn btn-outline-danger" data-tiptap-action="table-delete-col" title="Delete Col"><i class="bi bi-trash"></i></button>
            </div>
            <div class="btn-group btn-group-sm">
                <button type="button" class="btn btn-outline-info" data-tiptap-action="table-merge-cells" title="Merge Cells"><i class="bi bi-arrows-collapse"></i></button>
                <button type="button" class="btn btn-outline-info" data-tiptap-action="table-split-cell" title="Split Cell"><i class="bi bi-arrows-expand"></i></button>
                <button type="button" class="btn btn-outline-danger" data-tiptap-action="table-delete" title="Delete Table"><i class="bi bi-x-square"></i></button>
            </div>
            
            <!-- Table Colors Dropdown -->
            <div class="dropdown">
                <button class="btn btn-sm btn-outline-dark dropdown-toggle" type="button" data-bs-toggle="dropdown" title="Warna Tabel">
                    <i class="bi bi-palette"></i> Warna
                </button>
                <div class="dropdown-menu p-3" style="width: 200px;">
                    <label class="form-label fs-8 fw-bold">Warna Header / Latar</label>
                    <div class="d-flex flex-wrap gap-1 mb-2">
                        <button type="button" class="btn btn-sm" style="background: #ffffff; border: 1px solid #ccc; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#ffffff"></button>
                        <button type="button" class="btn btn-sm" style="background: #f8f9fa; border: 1px solid #ccc; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#f8f9fa"></button>
                        <button type="button" class="btn btn-sm" style="background: #0d6efd; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#0d6efd"></button>
                        <button type="button" class="btn btn-sm" style="background: #0dcaf0; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#0dcaf0"></button>
                        <button type="button" class="btn btn-sm" style="background: #198754; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#198754"></button>
                        <button type="button" class="btn btn-sm" style="background: #dc3545; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#dc3545"></button>
                        <button type="button" class="btn btn-sm" style="background: #ffc107; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#ffc107"></button>
                        <button type="button" class="btn btn-sm" style="background: #6c757d; width: 25px; height: 25px;" data-tiptap-action="table-bg" data-color="#6c757d"></button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Accordion -->
        <div class="btn-group btn-group-sm ps-2">
            <button type="button" class="btn btn-outline-secondary" data-tiptap-action="accordion" title="Insert Accordion"><i class="bi bi-view-list"></i>Table Accordion</button>
        </div>

        <!-- Fullscreen -->
        <div class="ms-auto btn-group btn-group-sm">
            <button type="button" class="btn btn-outline-dark" data-tiptap-action="fullscreen" title="Fullscreen"><i class="bi bi-arrows-fullscreen"></i></button>
        </div>

    </div>

    <!-- Tiptap Editor Area -->
    <div class="tiptap-editor-content p-3" style="min-height: 400px; max-height: 700px; overflow-y: auto;"></div>

    <!-- Hidden Input for Form Submission -->
    <input type="hidden" name="{{ $name }}" id="{{ $id }}" value="{{ $value }}" class="tiptap-hidden-input">
</div>

@push('scripts')
<style>
    /* Tiptap Editor Basic Styles */
    .tiptap-wrapper.fullscreen {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        z-index: 9999;
        background: var(--bs-body-bg);
        border-radius: 0 !important;
        margin: 0 !important;
    }
    .tiptap-wrapper.fullscreen .tiptap-editor-content {
        max-height: calc(100vh - 60px);
        height: 100%;
    }
    .tiptap-editor-content .ProseMirror {
        outline: none;
        min-height: 380px;
    }
    .tiptap-editor-content .ProseMirror > * + * {
        margin-top: 0.75em;
    }
    .tiptap-editor-content .ProseMirror ul,
    .tiptap-editor-content .ProseMirror ol {
        padding: 0 1rem;
    }
    .tiptap-editor-content .ProseMirror blockquote {
        border-left: 3px solid #dee2e6;
        padding-left: 1rem;
        font-style: italic;
    }
    .tiptap-editor-content .ProseMirror table {
        border-collapse: collapse;
        table-layout: fixed;
        width: 100%;
        margin: 0;
        overflow: hidden;
    }
    .tiptap-editor-content .ProseMirror table td,
    .tiptap-editor-content .ProseMirror table th {
        min-width: 1em;
        border: 2px solid #ced4da;
        padding: 8px;
        vertical-align: top;
        box-sizing: border-box;
        position: relative;
    }
    .tiptap-editor-content .ProseMirror table th {
        font-weight: bold;
        background-color: #f8f9fa;
    }
    .tiptap-editor-content .ProseMirror img {
        max-width: 100%;
        height: auto;
    }
    .tiptap-editor-content .ProseMirror iframe {
        width: 100%;
        min-height: 300px;
        border: none;
    }
    /* Active Button State */
    .tiptap-toolbar .btn.active {
        background-color: #e9ecef;
        box-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
    }
    
    /* Dark Mode Adjustments */
    [data-bs-theme="dark"] .tiptap-wrapper {
        background-color: var(--bs-gray-900) !important;
        border-color: var(--bs-gray-700) !important;
    }
    [data-bs-theme="dark"] .tiptap-toolbar {
        background-color: var(--bs-gray-800) !important;
        border-color: var(--bs-gray-700) !important;
    }
    [data-bs-theme="dark"] .tiptap-editor-content .ProseMirror table th {
        background-color: var(--bs-gray-800);
    }
    [data-bs-theme="dark"] .tiptap-editor-content .ProseMirror table td,
    [data-bs-theme="dark"] .tiptap-editor-content .ProseMirror table th {
        border-color: var(--bs-gray-700);
    }
    
    /* Accordion Details/Summary Style — always open in editor */
    .tiptap-editor-content .ProseMirror details {
        border: 2px solid #3b82f6;
        border-radius: 8px;
        margin-bottom: 1em;
        overflow: visible;
        background: transparent;
    }
    [data-bs-theme="dark"] .tiptap-editor-content .ProseMirror details {
        border-color: #60a5fa;
    }
    .tiptap-editor-content .ProseMirror summary {
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.6em 0.9em;
        background: linear-gradient(90deg, #1d4ed8, #3b82f6);
        color: #ffffff;
        cursor: default;  /* non-interactive in editor */
        border-bottom: 2px solid #3b82f6;
        border-radius: 6px 6px 0 0;
        display: block;
        user-select: text;
        pointer-events: auto;
    }
    [data-bs-theme="dark"] .tiptap-editor-content .ProseMirror summary {
        background: linear-gradient(90deg, #1e3a8a, #2563eb);
        border-color: #60a5fa;
    }
    .tiptap-editor-content .ProseMirror details > *:not(summary) {
        padding: 0;
        margin: 0;
    }
    /* Table inside accordion: full width, no extra margin */
    .tiptap-editor-content .ProseMirror details > .tableWrapper,
    .tiptap-editor-content .ProseMirror details > table {
        margin: 0 !important;
        width: 100% !important;
    }
    /* Prevent native details toggle in editor */
    .tiptap-editor-content .ProseMirror details summary::-webkit-details-marker {
        display: none;
    }
    .tiptap-editor-content .ProseMirror details summary::before {
        content: '▼ ';
        font-size: 0.7rem;
        opacity: 0.8;
    }
    /* Task List Styling */
    .tiptap-editor-content .ProseMirror ul[data-type="taskList"] {
        list-style: none !important;
        padding: 0 !important;
        margin: 0.5rem 0 !important;
    }
    .tiptap-editor-content .ProseMirror ul[data-type="taskList"] li[data-type="taskItem"] {
        display: flex !important;
        align-items: flex-start !important;
        gap: 0.6rem !important;
        margin-bottom: 0.4rem !important;
        list-style: none !important;
    }
    .tiptap-editor-content .ProseMirror ul[data-type="taskList"] li[data-type="taskItem"] > label {
        flex-shrink: 0 !important;
        user-select: none !important;
        margin-top: 0.25rem !important;
        cursor: pointer !important;
    }
    .tiptap-editor-content .ProseMirror ul[data-type="taskList"] li[data-type="taskItem"] > label input[type="checkbox"] {
        width: 1.1rem !important;
        height: 1.1rem !important;
        cursor: pointer !important;
        accent-color: #0284c7 !important;
        border-radius: 4px !important;
    }
    .tiptap-editor-content .ProseMirror ul[data-type="taskList"] li[data-type="taskItem"] > div {
        flex: 1 1 auto !important;
        min-width: 0 !important;
    }
    .tiptap-editor-content .ProseMirror ul[data-type="taskList"] li[data-type="taskItem"] > div > p {
        margin: 0 !important;
    }
    .tiptap-editor-content .ProseMirror ul[data-type="taskList"] li[data-type="taskItem"][data-checked="true"] > div > p {
        text-decoration: line-through !important;
        opacity: 0.6 !important;
    }

    /* PDF Embed Style */
    .tiptap-pdf-embed {
        display: flex !important;
        align-items: center !important;
        justify-content: space-between !important;
        gap: 1rem !important;
        padding: 0.9rem 1.25rem !important;
        border-radius: 16px !important;
        background-color: #ffffff !important;
        border: 1px solid rgba(0, 0, 0, 0.1) !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.05) !important;
        text-decoration: none !important;
        color: #1e293b !important;
        margin: 1.25rem 0 !important;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1) !important;
    }
    [data-bs-theme="dark"] .tiptap-pdf-embed {
        background-color: var(--bs-gray-800) !important;
        border-color: var(--bs-gray-700) !important;
        color: #f8fafc !important;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3) !important;
    }
    .tiptap-pdf-embed:hover {
        transform: translateY(-2px) !important;
        box-shadow: 0 8px 20px rgba(220, 53, 69, 0.15) !important;
        border-color: rgba(220, 53, 69, 0.4) !important;
    }
    .tiptap-pdf-info {
        display: flex;
        align-items: center;
        gap: 0.85rem;
        min-width: 0;
    }
    .tiptap-pdf-icon {
        width: 42px;
        height: 42px;
        border-radius: 12px;
        background: rgba(220, 53, 69, 0.12);
        color: #dc3545;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .tiptap-pdf-action {
        font-size: 0.8rem;
        font-weight: 600;
        color: #dc3545;
        background: rgba(220, 53, 69, 0.1);
        padding: 0.4rem 0.85rem;
        border-radius: 999px;
        display: flex;
        align-items: center;
        gap: 0.35rem;
        flex-shrink: 0;
    }
</style>
@endpush
