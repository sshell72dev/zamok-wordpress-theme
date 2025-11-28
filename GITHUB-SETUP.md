# Инструкция по выкладке проекта на GitHub

## Быстрый способ (рекомендуется)

Используйте автоматический скрипт:

1. Установите Git: https://git-scm.com/download/win (если еще не установлен)
2. Откройте PowerShell в папке проекта
3. Запустите скрипт:
   ```powershell
   .\setup-github.ps1
   ```
4. Следуйте инструкциям скрипта

Скрипт автоматически:
- Проверит наличие Git
- Настроит Git (если нужно)
- Инициализирует репозиторий
- Добавит все файлы
- Создаст первый коммит
- Покажет дальнейшие шаги

---

## Ручной способ

### Шаг 1: Установка Git (если не установлен)

1. Скачайте Git для Windows: https://git-scm.com/download/win
2. Установите Git, следуя инструкциям установщика
3. Перезапустите терминал/командную строку

## Шаг 2: Настройка Git (первый раз)

Откройте терминал в папке проекта и выполните:

```bash
git config --global user.name "Ваше Имя"
git config --global user.email "ваш.email@example.com"
```

## Шаг 3: Инициализация репозитория

```bash
cd D:\sites\zamok
git init
```

## Шаг 4: Добавление файлов

```bash
git add .
```

## Шаг 5: Первый коммит

```bash
git commit -m "Initial commit: WordPress тема Zamok01"
```

## Шаг 6: Создание репозитория на GitHub

1. Зайдите на https://github.com
2. Нажмите кнопку "+" в правом верхнем углу
3. Выберите "New repository"
4. Введите название репозитория (например: `zamok-wordpress-theme`)
5. Выберите Public или Private
6. **НЕ** ставьте галочки на "Initialize this repository with a README"
7. Нажмите "Create repository"

## Шаг 7: Подключение к удаленному репозиторию

После создания репозитория GitHub покажет инструкции. Выполните:

```bash
git remote add origin https://github.com/ВАШ_USERNAME/zamok-wordpress-theme.git
```

Замените `ВАШ_USERNAME` на ваш GitHub username.

## Шаг 8: Отправка кода на GitHub

```bash
git branch -M main
git push -u origin main
```

Если потребуется авторизация, GitHub попросит ввести логин и пароль (или токен доступа).

## Дальнейшая работа

После внесения изменений в проект:

```bash
git add .
git commit -m "Описание изменений"
git push
```

## Примечания

- Файл `.gitignore` уже создан и исключает ненужные файлы WordPress
- В репозиторий попадет только папка `zamok` с темой WordPress
- Конфиденциальные данные (wp-config.php) не будут загружены благодаря .gitignore

