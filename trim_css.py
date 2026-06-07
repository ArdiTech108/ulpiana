import re

file_path = r'C:\xampp3\htdocs\ulpiana-main\public\style.css'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

index = content.find('/* =============================================\n   ENHANCED ANIMATIONS PACKAGE\n   ============================================= */')

if index != -1:
    content = content[:index]
    with open(file_path, 'w', encoding='utf-8') as f:
        f.write(content.strip() + '\n')
    print('Trimmed style.css')
else:
    print('Animation package not found in style.css')
