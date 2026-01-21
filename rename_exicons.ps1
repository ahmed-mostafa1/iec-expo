$sourcePath = "c:\xampp\htdocs\iec-expo\public\img\exicons"
$counter = 1

# Get all PNG files sorted alphabetically
$files = Get-ChildItem -Path "$sourcePath\*.png" | Sort-Object Name

# Create a temporary directory to avoid naming conflicts
$tempPath = "$sourcePath\temp_rename"
New-Item -ItemType Directory -Path $tempPath -Force | Out-Null

# First, move all files to temp directory with new names
foreach ($file in $files) {
    $newName = "$counter.png"
    Move-Item -Path $file.FullName -Destination "$tempPath\$newName" -Force
    $counter++
}

# Then move them back to original directory
Get-ChildItem -Path "$tempPath\*.png" | ForEach-Object {
    Move-Item -Path $_.FullName -Destination "$sourcePath\$($_.Name)" -Force
}

# Remove temp directory
Remove-Item -Path $tempPath -Force

Write-Host "Successfully renamed $($counter - 1) files to sequential numbers (1.png to $($counter - 1).png)"
