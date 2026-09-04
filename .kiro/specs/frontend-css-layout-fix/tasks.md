# Implementation Plan

- [ ] 1. Write bug condition exploration test
  - **Property 1: Bug Condition** - CSS Layout Overflow & Out-of-Bounds Elements
  - **CRITICAL**: This test MUST FAIL on unfixed code - failure confirms the bug exists
  - **DO NOT attempt to fix the test or the code when it fails**
  - **NOTE**: This test encodes the expected behavior - it will validate the fix when it passes after implementation
  - **GOAL**: Surface counterexamples that demonstrate the three layout bugs exist
  - **Scoped PBT Approach**: Scope each sub-property to the concrete failing condition to ensure reproducibility
  - Test A — `isBugConditionA`: viewport_width=1200, column_count=3, container_has_overflow_hidden=false → assert all_cards_fully_visible=true (from Bug Condition A in design)
  - Test B — `isBugConditionB`: viewport_width=768, sidebar_margin_top=-60 → assert sidebar_within_bounds=true AND sidebar_margin_top_mobile=0 (from Bug Condition B in design)
  - Test C — `isBugConditionC`: content_type='iframe', element_width > container_width → assert element_width <= container_width AND overflow_hidden=true (from Bug Condition C in design)
  - The test assertions should match the Expected Behavior Properties (requirements 2.1–2.8) from design
  - Run tests on UNFIXED code
  - **EXPECTED OUTCOME**: Tests FAIL (this is correct - it proves the bugs exist)
  - Document counterexamples found:
    - "Sarana & Prasarana: kartu ke-3 terpotong di kanan saat viewport ≤1200px karena tidak ada overflow:hidden"
    - "Berita Detail: sidebar margin-top:-60px tidak di-reset di viewport <992px, sidebar overlap konten"
    - "Page: iframe YouTube meluap melewati .page-floating-card boundary"
  - Mark task complete when tests are written, run, and failures are documented
  - _Requirements: 1.1, 1.2, 1.3, 1.4, 1.5, 1.6, 1.7, 1.8_

- [ ] 2. Write preservation property tests (BEFORE implementing fix)
  - **Property 2: Preservation** - Existing Interactive Behavior Unchanged
  - **IMPORTANT**: Follow observation-first methodology
  - Observe on UNFIXED code for non-buggy inputs (cases where isBugCondition returns false):
    - Observe: dark mode toggle applies correct colors on `.card-jds-hover`, sidebar, `.page-floating-card` — record exact bg colors per selector
    - Observe: hover animation on `.card-jds-hover` triggers `translateY(-6px)` and `border-color: rgba(2,132,199,0.4)` — record the CSS values
    - Observe: sticky-top sidebar on desktop (viewport ≥992px) stays fixed while scrolling — record expected behavior
    - Observe: filter form on Sarana & Prasarana submits via GET and grid re-renders with filtered results
    - Observe: hero background slider cross-fades between images — CSS transition `opacity 1.5s` present and active
  - Write property-based tests: for all viewport widths ≥992px, layout renders two-column article+sidebar side-by-side (from Preservation Requirements in design)
  - Write property-based tests: for all non-iframe content types, `.page-detail-body` renders content without horizontal overflow
  - Write property-based tests: for any number of cards (1–50), grid breakpoints `col-md-6 col-lg-4` render consistently
  - Verify these tests PASS on UNFIXED code
  - **EXPECTED OUTCOME**: Tests PASS (this confirms baseline behavior to preserve)
  - Mark task complete when tests are written, run, and passing on unfixed code
  - _Requirements: 3.1, 3.2, 3.3, 3.4, 3.5, 3.6, 3.7, 3.8_

- [ ] 3. Fix for CSS layout overflow, sidebar out-of-bounds, and iframe containment

  - [ ] 3.1 Implement CSS fix in `public/css/front.css` — iframe & content overflow containment
    - Add `max-width: 100%; overflow-x: hidden;` to the existing `.page-detail-body` rule
    - Add new rule: `.page-detail-body iframe, .page-detail-body video { width: 100%; max-width: 100%; aspect-ratio: 16/9; height: auto; border: none; }`
    - Add responsive wrapper: `.page-detail-body .responsive-embed { position: relative; width: 100%; overflow: hidden; aspect-ratio: 16/9; }`
    - _Bug_Condition: isBugConditionC(X) where X.content_type IN ['iframe','video_embed'] AND X.element_width > X.container_width_
    - _Expected_Behavior: result.element_width <= result.container_width AND result.overflow_hidden = true_
    - _Preservation: Non-iframe content (text, table, accordion, images) must continue rendering with existing styles_
    - _Requirements: 1.6, 1.7, 2.6, 2.7, 3.5_

  - [ ] 3.2 Implement CSS fix in `public/css/front.css` — sidebar mobile responsive reset
    - Add new CSS class `.sidebar-berita-col` with `margin-top: -60px; position: relative; z-index: 10;` for desktop
    - Add media query `@media (max-width: 991.98px) { .sidebar-berita-col { margin-top: 0 !important; position: static; z-index: auto; } }` to reset sidebar on mobile/tablet
    - _Bug_Condition: isBugConditionB(X) where X.sidebar_margin_top < 0 AND X.viewport_width < 992_
    - _Expected_Behavior: result.sidebar_within_bounds = true AND result.sidebar_margin_top_mobile = 0_
    - _Preservation: At desktop (≥992px), sidebar sticky-top and two-column layout must remain identical_
    - _Requirements: 1.4, 1.5, 2.4, 2.5, 3.1, 3.2_

  - [ ] 3.3 Update `resources/views/frontend/berita/detail.blade.php` — replace inline style with CSS class
    - Find `<div class="col-lg-4" style="margin-top: -60px; position: relative; z-index: 10;">`
    - Replace with `<div class="col-lg-4 sidebar-berita-col">`
    - Remove the inline `style` attribute entirely — all positioning now controlled by `.sidebar-berita-col` in `front.css`
    - _Bug_Condition: isBugConditionB(X) — inline style cannot be overridden by media query_
    - _Expected_Behavior: CSS class enables proper media query responsive reset_
    - _Requirements: 1.4, 1.5, 2.4, 2.5_

  - [ ] 3.4 Implement CSS fix in `public/css/front.css` — Sarana & Prasarana container overflow
    - Locate the existing `.page-floating-card` rule and verify `overflow: hidden` behavior
    - Add new scoped rule for the Sarana & Prasarana grid wrapper: `.sp-grid-wrapper { overflow: hidden; }` (or use `overflow-x: clip` for better behavior)
    - Alternatively: add `overflow-x: hidden` to the `.container.pb-5` wrapper via a utility class `.container-clip { overflow-x: hidden; }`
    - Add `min-height: 100%` to ensure `.card-jds-hover` + Bootstrap `h-100` align properly for uniform card heights
    - _Bug_Condition: isBugConditionA(X) where X.viewport_width <= 1200 AND X.column_count = 3 AND NOT X.container_has_overflow_hidden_
    - _Expected_Behavior: result.all_cards_fully_visible = true AND result.right_edge_padding >= 12px_
    - _Preservation: Grid filter, pagination, badge rendering, and hover animations must remain unchanged_
    - _Requirements: 1.1, 1.2, 1.3, 2.1, 2.2, 2.3, 3.3, 3.4, 3.7_

  - [ ] 3.5 Update `resources/views/frontend/sarana_prasarana/index.blade.php` — apply container clip class
    - Find `<div class="container pb-5" style="margin-top: -50px; position: relative; z-index: 10;">`
    - Add class `container-clip` or apply `overflow-x: hidden` directly via additional class
    - Ensure Bootstrap `.row.g-4` is not clipped unintentionally (use `overflow-x: clip` or check gutter doesn't get cut)
    - _Requirements: 1.1, 1.2, 2.1, 2.2_

  - [ ] 3.6 Verify `.page-floating-card` negative margin compensation in `public/css/front.css`
    - Confirm existing `margin-top: -80px` on `.page-floating-card` does not need additional `padding-top` compensation
    - If page.blade.php has content overflow issues, add rule: `.page-floating-card { overflow: hidden; }` to contain any edge-case CKEditor content
    - Verify page.blade.php container `<div class="container pb-5">` does not need additional padding adjustments
    - _Requirements: 1.8, 2.8, 3.5_

  - [ ] 3.2 Verify bug condition exploration test now passes
    - **Property 1: Expected Behavior** - CSS Layout Elements Contained Within Boundaries
    - **IMPORTANT**: Re-run the SAME test from task 1 - do NOT write a new test
    - The test from task 1 encodes the expected behavior (requirements 2.1–2.8)
    - When this test passes, it confirms all three bug conditions (A, B, C) are resolved
    - Run all three bug condition exploration tests from step 1
    - **EXPECTED OUTCOME**: All tests PASS (confirms bugs A, B, and C are fixed)
    - _Requirements: 2.1, 2.2, 2.3, 2.4, 2.5, 2.6, 2.7, 2.8_

  - [ ] 3.3 Verify preservation tests still pass
    - **Property 2: Preservation** - Existing Interactive Behavior Unchanged
    - **IMPORTANT**: Re-run the SAME tests from task 2 - do NOT write new tests
    - Run all preservation property tests from step 2
    - **EXPECTED OUTCOME**: All tests PASS (confirms no regressions)
    - Confirm: dark mode, hover animations, sticky sidebar, filter/search, pagination, hero slider all still behave identically

- [ ] 4. Checkpoint - Ensure all tests pass
  - Re-run all tests: bug condition tests (now should PASS) and preservation tests (should remain PASSING)
  - Open each affected page in browser at viewport widths: 375px (mobile), 768px (tablet), 1200px (desktop)
  - Visually verify: Sarana & Prasarana grid fully visible, sidebar berita within bounds, iframe/embed contained in card
  - Toggle dark mode and verify all three pages still render correctly in both light and dark theme
  - Submit filter on Sarana & Prasarana page and verify grid re-renders cleanly
  - Ensure all tests pass; ask the user if questions arise.
