@echo off
REM Build WordPress.org Submission ZIP for Klaro Theme
REM Windows batch script version

setlocal enabledelayedexpansion

echo Building WordPress.org submission ZIP for Klaro Theme...
echo.

REM Get the directory where the script is located
set "SCRIPT_DIR=%~dp0"
set "THEME_DIR=%SCRIPT_DIR%"
set "PARENT_DIR=%THEME_DIR%.."
set "ZIP_NAME=klaro.zip"
set "ZIP_PATH=%PARENT_DIR%\%ZIP_NAME%"

REM Check if we're in the right directory
if not exist "%THEME_DIR%style.css" (
    echo Error: style.css not found. Please run this script from the theme directory.
    exit /b 1
)

REM Remove old zip if it exists
if exist "%ZIP_PATH%" (
    echo Removing existing %ZIP_NAME%...
    del "%ZIP_PATH%"
)

REM Change to theme directory
cd /d "%THEME_DIR%"

echo Creating ZIP file...
echo.

REM Check if PowerShell is available (Windows 7+)
where powershell >nul 2>&1
if %ERRORLEVEL% EQU 0 (
    REM Use PowerShell to create zip
    powershell -NoProfile -ExecutionPolicy Bypass -Command ^
        "Get-ChildItem -Path '.' -Recurse | Where-Object { ^
            $_.FullName -notmatch '\.git' -and ^
            $_.Name -ne '.gitignore' -and ^
            $_.Name -ne 'CLAUDE.md' -and ^
            $_.Name -ne 'README.md' -and ^
            $_.Name -ne 'CHANGELOG.md' -and ^
            $_.FullName -notmatch '\\banners\\' -and ^
            $_.FullName -notmatch '\\woocommerce\\single-product\\' -and ^
            $_.Name -ne 'build-wp-org-zip.bat' -and ^
            $_.Name -ne 'build-wp-org-zip.sh' -and ^
            $_.Name -ne 'WP-ORG-SUBMISSION.md' -and ^
            $_.Name -ne '.DS_Store' -and ^
            $_.FullName -notmatch 'node_modules' -and ^
            $_.FullName -notmatch '\.vscode' -and ^
            $_.FullName -notmatch '\.idea' ^
        } | Compress-Archive -DestinationPath '%ZIP_PATH%' -Force"
    
    if exist "%ZIP_PATH%" (
        echo.
        echo ZIP file created successfully!
        echo Location: %ZIP_PATH%
        echo.
        echo Ready for WordPress.org submission!
    ) else (
        echo Error: ZIP file was not created.
        exit /b 1
    )
) else (
    echo Error: PowerShell is required to create ZIP files on Windows.
    echo Please install PowerShell or use a ZIP utility like 7-Zip.
    echo.
    echo Manual exclusion list:
    echo   - .gitignore
    echo   - CLAUDE.md
    echo   - README.md
    echo   - CHANGELOG.md
    echo   - banners\ folder
    echo   - woocommerce\single-product\ folder (if empty)
    exit /b 1
)

endlocal
