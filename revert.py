import re

file_path = r'C:\xampp3\htdocs\ulpiana-main\resources\views\index.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

content = re.sub(r'<h2 class="section-title wave-underline">', r'<h2 class="section-title">', content)
content = re.sub(r'class="stat-box reveal reveal-up hover-glow"', r'class="stat-box reveal"', content)
content = re.sub(r'class="stat-box reveal reveal-up hover-glow delay-1"', r'class="stat-box reveal delay-1"', content)
content = re.sub(r'class="stat-box reveal reveal-up hover-glow delay-2"', r'class="stat-box reveal delay-2"', content)
content = re.sub(r'<div class="features-grid stagger-children">', r'<div class="features-grid">', content)
content = re.sub(r'class="feature-card reveal reveal-scale hover-glow"', r'class="feature-card reveal"', content)
content = re.sub(r'class="glass-panel hover-glow" style="background:', r'class="glass-panel" style="background:', content)
content = re.sub(r'class="btn btn-primary btn-ripple"', r'class="btn btn-primary"', content)
content = re.sub(r'class="btn btn-secondary btn-ripple"', r'class="btn btn-secondary"', content)
content = re.sub(r'class="resource-card reveal reveal-scale hover-glow"', r'class="resource-card reveal"', content)
content = re.sub(r'class="eco-item reveal reveal-up hover-glow"', r'class="eco-item reveal"', content)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print('Reverted index.blade.php animations!')
