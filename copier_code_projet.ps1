# === copier_code_projet.ps1 ===
# Copie tout le code du projet (PHP, HTML, CSS, JS...) dans le presse-papiers

# Récupère le répertoire courant
$workspaceDir = Get-Location
$tempFile = "$env:TEMP\code_content_$(Get-Date -Format 'yyyyMMdd_HHmmss').txt"

Write-Host "🔍 Recherche des fichiers dans le workspace..."
Write-Host "📂 Workspace: $workspaceDir"

# Trouver les fichiers utiles (.php, .html, .css, .js)
$files = Get-ChildItem -Path $workspaceDir -Recurse -File -Include *.php, *.html, *.css, *.js |
         Where-Object { $_.FullName -notmatch '\\node_modules\\|\\vendor\\|\\.git\\|\\dist\\|\\build\\' }

if ($files.Count -eq 0) {
    Write-Host "❌ Aucun fichier trouvé (.php, .html, .css ou .js)."
    exit
}

Write-Host "🔢 Nombre de fichiers trouvés:" $files.Count

# Crée un fichier temporaire vide
Set-Content -Path $tempFile -Value ""

foreach ($file in $files) {
    Add-Content -Path $tempFile -Value "`n`n// ============================================"
    Add-Content -Path $tempFile -Value "// FICHIER: $($file.FullName)"
    Add-Content -Path $tempFile -Value "// ============================================`n"
    Get-Content $file.FullName | Add-Content -Path $tempFile
}

# Copie le contenu dans le presse-papiers Windows
Get-Content $tempFile -Raw | Set-Clipboard

Write-Host "✅ Contenu copié dans le presse-papiers !"
Write-Host "📋 $($files.Count) fichiers copiés (PHP, HTML, CSS, JS)"
