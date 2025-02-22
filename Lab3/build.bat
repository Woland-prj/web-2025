@echo off
setlocal enabledelayedexpansion

:: Проверяем, передан ли аргумент с именем файла
if "%1"=="" (
    echo Ошибка: не указано имя файла
    exit /b 1
)

set "SOURCE=%1"
set "TARGET=%~n1.cgi"
set "DEST=C:\laragon\www\cgi-bin\%TARGET%"

:: Компилируем файл
fpc "%SOURCE%"
if errorlevel 1 (
    echo Ошибка компиляции!
    exit /b 1
)

:: Удаляем мусор
del "%~n1.o"

:: Удаляем существующий файл перед переименованием
if exist "%TARGET%" del "%TARGET%"

:: Переименовываем скомпилированный файл
ren "%~n1.exe" "%TARGET%"

:: Копируем файл в целевую папку, заменяя существующий
copy /Y "%TARGET%" "%DEST%"

if errorlevel 1 (
    echo Ошибка копирования файла!
    exit /b 1
)

echo Готово! Файл %TARGET% скопирован в %DEST%