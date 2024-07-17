    <div class="container-fluid">
        <div class="row mb-3">
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <select class="form-select" onchange="selectFontSize()" id="selectFontSize">
                    <option value="12px">12px</option>
                    <option value="14px">14px</option>
                    <option value="16px">16px</option>
                    <option value="18px">18px</option>
                    <option value="20px">20px</option>
                    <option value="22px">22px</option>
                    <option value="24px">24px</option>
                </select>
            </div>
            <div class="col-12 col-md-4 mb-2 mb-md-0">
                <select class="form-select" onchange="selectTheme()" id="selectTheme"></select>
            </div>
            <div class="col-12 col-md-4">
                <select class="form-select" onchange="selectLanguageMode()" id="selectLanguageMode"></select>
            </div>
        </div>
    </div>
    <div class="editor" id="editor" style="height:800px;"></div>
    <script src="../js/ace/ace.js"></script>
    <script>
        let editor;
        let languageModeIds = {};

        const supportedLanguages = [
            { id: 45, name: "Assembly (NASM 2.14.02)", mode: "assembly_x86" },
            { id: 46, name: "Bash (5.0.0)", mode: "sh" }, 
            { id: 52, name: "C++ (GCC 7.4.0)", mode: "c_cpp" },
            { id: 53, name: "C++ (GCC 8.3.0)", mode: "c_cpp" },
            { id: 54, name: "C++ (GCC 9.2.0)", mode: "c_cpp" },
            { id: 76, name: "C++ (Clang 7.0.1)", mode: "c_cpp" }, 
            { id: 75, name: "C (Clang 7.0.1)", mode: "c_cpp" },
            { id: 48, name: "C (GCC 7.4.0)", mode: "c_cpp" },
            { id: 49, name: "C (GCC 8.3.0)", mode: "c_cpp" },
            { id: 50, name: "C (GCC 9.2.0)", mode: "c_cpp" },
            { id: 51, name: "C# (Mono 6.6.0.161)", mode: "csharp" },
            { id: 62, name: "Java (OpenJDK 13.0.1)", mode: "java" },
            { id: 91, name: "Java (JDK 17.0.6)", mode: "java" },
            { id: 63, name: "JavaScript (Node.js 12.14.0)", mode: "javascript" },
            { id: 93, name: "JavaScript (Node.js 18.15.0)", mode: "javascript" },
            { id: 68, name: "PHP (7.4.1)", mode: "php" },
            { id: 43, name: "Plain Text", mode: "plain_text" },
            { id: 70, name: "Python (2.7.17)", mode: "python" },
            { id: 92, name: "Python (3.11.2)", mode: "python" },
            { id: 71, name: "Python (3.8.1)", mode: "python" },
            { id: 72, name: "Ruby (2.7.0)", mode: "ruby" },
            { id: 73, name: "Rust (1.40.0)", mode: "rust" },
            { id: 74, name: "TypeScript (3.7.4)", mode: "typescript" },
            { id: 94, name: "TypeScript (5.0.3)", mode: "typescript" }
        ];

        window.onload = function() {
            editor = ace.edit("editor");
            populateThemes();
            populateLanguageModes();
            applyInitialTheme();
            applyInitialFontSize();
            applyInitialLanguageMode();
            //console.log(languageModeIds);
        }

        function populateThemes() {
            const themes = [
                'ambiance', 'chaos', 'chrome', 'clouds', 'clouds_midnight', 'cobalt',
                'crimson_editor', 'dawn', 'dracula', 'dreamweaver', 'eclipse', 'github',
                'gob', 'gruvbox', 'idle_fingers', 'iplastic', 'katzenmilch', 'kr_theme',
                'kuroir', 'merbivore', 'merbivore_soft', 'mono_industrial', 'monokai',
                'nord_dark', 'pastel_on_dark', 'solarized_dark', 'solarized_light',
                'sqlserver', 'terminal', 'textmate', 'tomorrow', 'tomorrow_night',
                'tomorrow_night_blue', 'tomorrow_night_bright', 'tomorrow_night_eighties',
                'twilight', 'vibrant_ink', 'xcode'
            ];
            const themeSelect = document.getElementById("selectTheme");
            themes.forEach(theme => {
                const option = document.createElement("option");
                option.value = theme;
                option.textContent = theme;
                themeSelect.appendChild(option);
            });
        }

        function populateLanguageModes() {
            const languageSelect = document.getElementById("selectLanguageMode");
            supportedLanguages.forEach(lang => {
                const option = document.createElement("option");
                option.value = lang.mode;
                option.textContent = lang.name;
                languageSelect.appendChild(option);
                languageModeIds[lang.name] = lang.id;
            });
        }

        function applyInitialTheme() {
            const themeSelect = document.getElementById("selectTheme");
            themeSelect.value = 'monokai';  // Default theme
            editor.setTheme(`ace/theme/monokai`);
        }

        function applyInitialFontSize() {
            const fontSizeSelect = document.getElementById("selectFontSize");
            fontSizeSelect.value = '14px';  // Default font size
            editor.setFontSize('14px');
        }

        function applyInitialLanguageMode() {
            const languageSelect = document.getElementById("selectLanguageMode");
            languageSelect.value = 'c_cpp';  // Default language mode
            editor.session.setMode(`ace/mode/c_cpp`);
        }

        function selectFontSize() {
            const fontSize = document.getElementById("selectFontSize").value;
            editor.setFontSize(fontSize);
        }

        function selectTheme() {
            const theme = document.getElementById("selectTheme").value;
            editor.setTheme(`ace/theme/${theme}`);
        }

        function selectLanguageMode() {
            const mode = document.getElementById("selectLanguageMode").value;
            editor.session.setMode(`ace/mode/${mode}`);
        }
    </script>
