# PowerShell скрипт для настройки Git и подготовки к выкладке на GitHub
# Запуск: .\setup-github.ps1

Write-Host "========================================" -ForegroundColor Cyan
Write-Host "Настройка Git репозитория для GitHub" -ForegroundColor Cyan
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Проверка наличия Git
Write-Host "[1/6] Проверка установки Git..." -ForegroundColor Yellow
try {
    $gitVersion = git --version 2>&1
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Git установлен: $gitVersion" -ForegroundColor Green
    } else {
        throw "Git не найден"
    }
} catch {
    Write-Host "✗ Git не установлен!" -ForegroundColor Red
    Write-Host ""
    Write-Host "Пожалуйста, установите Git:" -ForegroundColor Yellow
    Write-Host "1. Скачайте с https://git-scm.com/download/win" -ForegroundColor White
    Write-Host "2. Установите Git" -ForegroundColor White
    Write-Host "3. Перезапустите этот скрипт" -ForegroundColor White
    Write-Host ""
    Read-Host "Нажмите Enter для выхода"
    exit 1
}

Write-Host ""

# Проверка конфигурации Git
Write-Host "[2/6] Проверка конфигурации Git..." -ForegroundColor Yellow
$userName = git config --global user.name 2>&1
$userEmail = git config --global user.email 2>&1

if ([string]::IsNullOrWhiteSpace($userName) -or [string]::IsNullOrWhiteSpace($userEmail)) {
    Write-Host "⚠ Git не настроен. Требуется настройка." -ForegroundColor Yellow
    Write-Host ""
    $inputName = Read-Host "Введите ваше имя для Git (например: Иван Иванов)"
    $inputEmail = Read-Host "Введите ваш email для Git (например: ivan@example.com)"
    
    git config --global user.name $inputName
    git config --global user.email $inputEmail
    
    Write-Host "✓ Git настроен" -ForegroundColor Green
} else {
    Write-Host "✓ Git уже настроен:" -ForegroundColor Green
    Write-Host "  Имя: $userName" -ForegroundColor White
    Write-Host "  Email: $userEmail" -ForegroundColor White
}

Write-Host ""

# Проверка существования репозитория
Write-Host "[3/6] Проверка Git репозитория..." -ForegroundColor Yellow
if (Test-Path ".git") {
    Write-Host "✓ Git репозиторий уже инициализирован" -ForegroundColor Green
} else {
    Write-Host "Инициализация нового Git репозитория..." -ForegroundColor Yellow
    git init
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Репозиторий инициализирован" -ForegroundColor Green
    } else {
        Write-Host "✗ Ошибка при инициализации репозитория" -ForegroundColor Red
        Read-Host "Нажмите Enter для выхода"
        exit 1
    }
}

Write-Host ""

# Проверка .gitignore
Write-Host "[4/6] Проверка .gitignore..." -ForegroundColor Yellow
if (Test-Path ".gitignore") {
    Write-Host "✓ Файл .gitignore найден" -ForegroundColor Green
} else {
    Write-Host "⚠ Файл .gitignore не найден" -ForegroundColor Yellow
}

Write-Host ""

# Добавление файлов
Write-Host "[5/6] Добавление файлов в репозиторий..." -ForegroundColor Yellow
git add .
if ($LASTEXITCODE -eq 0) {
    $fileCount = (git status --short | Measure-Object -Line).Lines
    Write-Host "✓ Файлы добавлены ($fileCount файлов)" -ForegroundColor Green
} else {
    Write-Host "✗ Ошибка при добавлении файлов" -ForegroundColor Red
    Read-Host "Нажмите Enter для выхода"
    exit 1
}

Write-Host ""

# Проверка наличия коммитов
Write-Host "[6/6] Проверка коммитов..." -ForegroundColor Yellow
$commitCount = (git log --oneline 2>&1 | Measure-Object -Line).Lines

if ($commitCount -eq 0) {
    Write-Host "Создание первого коммита..." -ForegroundColor Yellow
    git commit -m "Initial commit: WordPress тема Zamok01"
    if ($LASTEXITCODE -eq 0) {
        Write-Host "✓ Первый коммит создан" -ForegroundColor Green
    } else {
        Write-Host "⚠ Не удалось создать коммит (возможно, нет изменений)" -ForegroundColor Yellow
    }
} else {
    Write-Host "✓ Коммиты уже существуют ($commitCount коммитов)" -ForegroundColor Green
}

Write-Host ""
Write-Host "========================================" -ForegroundColor Cyan
Write-Host "✓ Настройка завершена!" -ForegroundColor Green
Write-Host "========================================" -ForegroundColor Cyan
Write-Host ""

# Проверка подключения к удаленному репозиторию
$remoteUrl = git remote get-url origin 2>&1
if ($LASTEXITCODE -eq 0) {
    Write-Host "✓ Удаленный репозиторий уже подключен:" -ForegroundColor Green
    Write-Host "  $remoteUrl" -ForegroundColor White
    Write-Host ""
    Write-Host "Для отправки изменений выполните:" -ForegroundColor Yellow
    Write-Host "  git push -u origin main" -ForegroundColor White
} else {
    Write-Host "Следующие шаги:" -ForegroundColor Yellow
    Write-Host ""
    Write-Host "1. Создайте репозиторий на GitHub:" -ForegroundColor White
    Write-Host "   - Зайдите на https://github.com" -ForegroundColor Gray
    Write-Host "   - Нажмите '+' → 'New repository'" -ForegroundColor Gray
    Write-Host "   - Введите название (например: zamok-wordpress-theme)" -ForegroundColor Gray
    Write-Host "   - НЕ ставьте галочку 'Initialize with README'" -ForegroundColor Gray
    Write-Host "   - Нажмите 'Create repository'" -ForegroundColor Gray
    Write-Host ""
    Write-Host "2. Подключите удаленный репозиторий:" -ForegroundColor White
    Write-Host "   git remote add origin https://github.com/ВАШ_USERNAME/НАЗВАНИЕ_РЕПОЗИТОРИЯ.git" -ForegroundColor Cyan
    Write-Host ""
    Write-Host "3. Отправьте код на GitHub:" -ForegroundColor White
    Write-Host "   git branch -M main" -ForegroundColor Cyan
    Write-Host "   git push -u origin main" -ForegroundColor Cyan
    Write-Host ""
}

Write-Host ""
Write-Host "Для просмотра статуса репозитория:" -ForegroundColor Yellow
Write-Host "  git status" -ForegroundColor White
Write-Host ""
Read-Host "Нажмите Enter для выхода"

