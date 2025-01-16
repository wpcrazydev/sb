<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Code Editor</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.32.2/ace.js"></script>
    <style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
    }

    .editor-container {
        display: block;
        margin: 10px 20px;
        height: calc(100vh - 120px);
        overflow-x: auto;
        white-space: nowrap;
    }

    .editor-section {
        width: max-content;
        min-width: 100%;
        display: flex;
        flex-direction: column;
        height: 100%;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .editor-header {
        background: #2F3129;
        color: white;
        padding: 8px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .editor-controls {
        display: flex;
        gap: 5px;
    }

    .control-btn {
        background: #444;
        border: none;
        color: white;
        padding: 4px 8px;
        border-radius: 3px;
        cursor: pointer;
        font-size: 12px;
    }

    .control-btn:hover {
        background: #555;
    }

    .editor {
        flex: 1;
        min-width: 800px;
    }

    .button-container {
        display: none;
    }

    .save-btn {
        background-color: #4CAF50;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 5px;
        transition: background-color 0.2s;
    }

    .save-btn:hover {
        background-color: #45a049;
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .editor-container {
            margin: 10px;
            height: calc(100vh - 110px);
        }
    }

    .main-header {
        background: #333;
        color: white;
        padding: 15px 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
    }

    .main-header h1 {
        margin: 0;
        font-size: 1.5rem;
    }

    .theme-switcher-bar {
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: start;
        gap: 10px;
    }

    .theme-switch {
        position: relative;
        display: inline-block;
        width: 70px;
        height: 32px;
        background: #e9ecef;
        border-radius: 20px;
        cursor: pointer;
        padding: 4px;
    }

    .theme-switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #e9ecef;
        transition: .4s;
        border-radius: 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0 8px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 24px;
        width: 24px;
        left: 4px;
        bottom: 3px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
    }

    .sun-icon,
    .moon-icon {
        font-size: 16px;
        z-index: 1;
    }

    .sun-icon {
        color: #ffd43b;
        margin-left: -3px;
    }

    .moon-icon {
        color: #868e96;
        margin-right: -3px;
    }

    input:checked+.slider {
        background-color: #495057;
    }

    input:checked+.slider:before {
        transform: translateX(38px);
    }

    .file-btn {
        background-color: #007bff;
        color: white;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        padding: 8px 16px;
        display: flex;
        align-items: center;
        gap: 5px;
        font-size: 12px;
        transition: background-color 0.2s;
    }

    .file-btn:hover {
        background-color: #0056b3;
    }

    .file-btn svg {
        stroke: currentColor;
    }

    .editor-title {
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .back-btn {
        background: none;
        border: none;
        color: #fff;
        cursor: pointer;
        padding: 2px;
        display: flex;
        align-items: center;
        opacity: 0.7;
        transition: opacity 0.2s;
    }

    .back-btn:hover {
        opacity: 1;
    }
    </style>
</head>

<body>
    <header class="main-header">
        <h1>Code Editor</h1>
        <button class="save-btn" onclick="saveCode()">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z"></path>
                <polyline points="17 21 17 13 7 13 7 21"></polyline>
                <polyline points="7 3 7 8 15 8"></polyline>
            </svg>
        </button>
    </header>

    <div class="theme-switcher-bar">
        <button class="file-btn" onclick="loadFile('css')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <path d="M8 13h8"></path>
                <path d="M8 17h8"></path>
            </svg>
            Custom CSS
        </button>
        <button class="file-btn" onclick="loadFile('js')">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"></path>
                <polyline points="14 2 14 8 20 8"></polyline>
                <path d="M8 13h8"></path>
                <path d="M8 17h8"></path>
            </svg>
            Custom JS
        </button>
        <label class="theme-switch">
            <input type="checkbox" id="themeToggle">
            <span class="slider">
                <span class="sun-icon">☀️</span>
                <span class="moon-icon">🌙</span>
            </span>
        </label>
    </div>

    <div class="editor-container">
        <div class="editor-section">
            <div class="editor-header">
                <div class="editor-title">
                    <span id="editorType">PHP/HTML</span>
                    <button id="backButton" onclick="resetToPhp()" class="back-btn" style="display: none;">
                        <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3">
                            <path d="M19 12H5M12 19l-7-7 7-7"/>
                        </svg>
                    </button>
                </div>
                <div class="editor-controls">
                    <button class="control-btn" onclick="toggleFullscreen(this.parentElement.parentElement.parentElement)">⛶</button>
                </div>
            </div>
            <div id="htmlEditor" class="editor"></div>
        </div>
    </div>

    <script>
    // Initialize editors
    const htmlEditor = ace.edit("htmlEditor");

    // Configure editor
    htmlEditor.setTheme("ace/theme/monokai");
    htmlEditor.session.setMode("ace/mode/php");
    htmlEditor.setOptions({
        fontSize: "14px",
        enableBasicAutocompletion: true,
        enableLiveAutocompletion: true,
        enableSnippets: true,
        showPrintMargin: false,
    });

    // Set the content from PHP
    htmlEditor.setValue(<?= json_encode($content ?? '') ?>);

    // Clear selection and move cursor to start
    htmlEditor.clearSelection();
    htmlEditor.moveCursorTo(0, 0);

    // Add tracking for unsaved changes
    let hasUnsavedChanges = false;
    htmlEditor.on('change', () => {
        hasUnsavedChanges = true;
    });

    // Add variables to store unsaved content
    let phpContent = <?= json_encode($content ?? '') ?>;
    let cssContent = '';
    let jsContent = '';
    let currentFileType = 'php';

    function loadFile(type) {
        // Store current content before switching
        saveCurrentContent();

        let endpoint = '';
        let filename = '';
        
        if (type === 'css') {
            endpoint = '<?= base_url(env('app.superAdminURL') . '/load-css') ?>';
            filename = 'custom.css';
            currentFileType = 'css';
            document.getElementById('editorType').textContent = 'Custom CSS';
            document.getElementById('backButton').style.display = 'block';
            
            // If we have stored CSS content, use it instead of loading from server
            if (cssContent) {
                updateEditor('css', cssContent);
                return;
            }
        } else if (type === 'js') {
            endpoint = '<?= base_url(env('app.superAdminURL') . '/load-js') ?>';
            filename = 'custom.js';
            currentFileType = 'js';
            document.getElementById('editorType').textContent = 'Custom JS';
            document.getElementById('backButton').style.display = 'block';
            
            // If we have stored JS content, use it instead of loading from server
            if (jsContent) {
                updateEditor('js', jsContent);
                return;
            }
        }

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ filename: filename })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                updateEditor(type, data.content);
            } else {
                alert('Error loading file: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error loading file');
        });
    }

    function saveCurrentContent() {
        const currentContent = htmlEditor.getValue();
        switch(currentFileType) {
            case 'php':
                phpContent = currentContent;
                break;
            case 'css':
                cssContent = currentContent;
                break;
            case 'js':
                jsContent = currentContent;
                break;
        }
    }

    function updateEditor(type, content) {
        htmlEditor.setValue(content);
        htmlEditor.clearSelection();
        htmlEditor.moveCursorTo(0, 0);
        
        // Set appropriate mode based on file type
        if (type === 'css') {
            htmlEditor.session.setMode("ace/mode/css");
        } else if (type === 'js') {
            htmlEditor.session.setMode("ace/mode/javascript");
        } else {
            htmlEditor.session.setMode("ace/mode/php");
        }
    }

    function resetToPhp() {
        // Store current content before switching back
        saveCurrentContent();
        
        currentFileType = 'php';
        document.getElementById('editorType').textContent = 'PHP/HTML';
        document.getElementById('backButton').style.display = 'none';
        
        // Use stored PHP content
        updateEditor('php', phpContent);
    }

    function saveCode() {
        // Store current content before saving
        saveCurrentContent();
        
        const content = htmlEditor.getValue();
        let endpoint = '<?= base_url(env('app.superAdminURL') . '/save-code') ?>';
        
        // If editing CSS or JS, use different endpoints
        if (currentFileType === 'css') {
            endpoint = '<?= base_url(env('app.superAdminURL') . '/save-css') ?>';
        } else if (currentFileType === 'js') {
            endpoint = '<?= base_url(env('app.superAdminURL') . '/save-js') ?>';
        }

        fetch(endpoint, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                page: <?= json_encode($page ?? '') ?>,
                content: content
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                hasUnsavedChanges = false;
                alert('Changes saved successfully!');
            } else {
                alert('Error saving changes: ' + (data.error || 'Unknown error'));
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving changes');
        });
    }

    // Fullscreen toggle function
    function toggleFullscreen(section) {
        if (section.classList.contains('fullscreen')) {
            section.style.position = '';
            section.style.top = '';
            section.style.left = '';
            section.style.width = '';
            section.style.height = '';
            section.style.zIndex = '';
            section.classList.remove('fullscreen');
        } else {
            section.style.position = 'fixed';
            section.style.top = '20px';
            section.style.left = '20px';
            section.style.width = 'calc(100% - 40px)';
            section.style.height = 'calc(100% - 40px)';
            section.style.zIndex = '1000';
            section.classList.add('fullscreen');
        }
        // Trigger resize event for Ace editor
        const editorId = section.querySelector('.editor').id;
        const editor = ace.edit(editorId);
        editor.resize();
    }

    // Handle editor resize
    const resizeObserver = new ResizeObserver(entries => {
        for (let entry of entries) {
            const editorElement = entry.target.querySelector('.editor');
            if (editorElement) {
                const editor = ace.edit(editorElement);
                editor.resize();
            }
        }
    });

    // Observe each editor section
    document.querySelectorAll('.editor-section').forEach(section => {
        resizeObserver.observe(section);
    });

    // Add theme switching functionality
    const themeToggle = document.getElementById('themeToggle');
    const themeSwitcherBar = document.querySelector('.theme-switcher-bar');

    themeToggle.addEventListener('change', function() {
        const isDark = this.checked;

        // Update editor theme
        htmlEditor.setTheme(isDark ? "ace/theme/monokai" : "ace/theme/chrome");

        // Update switcher bar appearance
        themeSwitcherBar.classList.toggle('dark', isDark);

        // Store preference
        localStorage.setItem('editorTheme', isDark ? 'dark' : 'light');
    });

    // Load saved theme preference
    window.addEventListener('load', () => {
        const savedTheme = localStorage.getItem('editorTheme');
        if (savedTheme) {
            themeToggle.checked = savedTheme === 'dark';
            themeToggle.dispatchEvent(new Event('change'));
        }
    });

    // Add warning when leaving page with unsaved changes
    window.addEventListener('beforeunload', function(e) {
        if (hasUnsavedChanges) {
            e.preventDefault();
            e.returnValue = '';
        }
    });
    </script>
</body>

</html>