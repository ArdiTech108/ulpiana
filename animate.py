import re

file_path = r'C:\xampp3\htdocs\ulpiana-main\resources\views\index.blade.php'
with open(file_path, 'r', encoding='utf-8') as f:
    content = f.read()

content = re.sub(r'<h2 class="section-title">', r'<h2 class="section-title wave-underline">', content)
content = re.sub(r'class="stat-box reveal"', r'class="stat-box reveal reveal-up hover-glow"', content)
content = re.sub(r'class="stat-box reveal delay-1"', r'class="stat-box reveal reveal-up hover-glow delay-1"', content)
content = re.sub(r'class="stat-box reveal delay-2"', r'class="stat-box reveal reveal-up hover-glow delay-2"', content)
content = re.sub(r'<div class="features-grid">', r'<div class="features-grid stagger-children">', content)
content = re.sub(r'class="feature-card reveal"', r'class="feature-card reveal reveal-scale hover-glow"', content)
content = re.sub(r'class="glass-panel" style="background:', r'class="glass-panel hover-glow" style="background:', content)
content = re.sub(r'class="btn btn-primary"', r'class="btn btn-primary btn-ripple"', content)
content = re.sub(r'class="btn btn-secondary"', r'class="btn btn-secondary btn-ripple"', content)
content = re.sub(r'class="resource-card reveal"', r'class="resource-card reveal reveal-scale hover-glow"', content)
content = re.sub(r'class="eco-item reveal"', r'class="eco-item reveal reveal-up hover-glow"', content)

with open(file_path, 'w', encoding='utf-8') as f:
    f.write(content)

print('Updated index.blade.php with animations!')
