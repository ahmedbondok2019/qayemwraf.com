from PIL import Image, ImageDraw, ImageFont, ImageFilter
import os

# We will create a high-resolution, beautiful transparent watermark PNG
# Size: 1000 x 1000
W, H = 1000, 1000
watermark = Image.new('RGBA', (W, H), (0, 0, 0, 0))
draw = ImageDraw.Draw(watermark)

# Color: Grey (#8A92A6) with semi-transparency and smooth rounded feel
# Let's draw the stylized "قائم ورف" block kufic letters matching the reference image:
# In the reference image:
# Top: "قائم" in large stylized rounded rectangles / block calligraphy
# Right side: "9" or "و"
# Bottom: "رف"

# Let's check available fonts in Windows to see if Cairo, Tajawal, Arial Bold, or Segoe UI are present
font_paths = [
    'C:/Windows/Fonts/seguiemj.ttf',
    'C:/Windows/Fonts/segoeui.ttf',
    'C:/Windows/Fonts/arialbd.ttf',
    'C:/Windows/Fonts/arial.ttf',
    'C:/Windows/Fonts/tahoma.ttf',
    'C:/Windows/Fonts/tahomabd.ttf',
    'C:/Windows/Fonts/tradbdo.ttf'
]

font_file = 'C:/Windows/Fonts/arialbd.ttf'
for fp in font_paths:
    if os.path.exists(fp):
        font_file = fp
        break

print("Using font:", font_file)

# Let's create the watermark directly from vector / geometric shapes matching the exact logo of قائم ورف:
# Color for text: #7F8C9B with alpha
text_color = (120, 130, 145, 230)
w_color = (235, 240, 245, 240)

# Let's render high-res text and shapes
try:
    font_large = ImageFont.truetype(font_file, 260)
    font_mid = ImageFont.truetype(font_file, 220)
    font_w = ImageFont.truetype(font_file, 240)
except Exception as e:
    font_large = font_mid = font_w = ImageFont.load_default()

# We can composite the layout:
# "قائم" at top-left/center
# "و" at middle-right
# "رف" at bottom-left/center
# Or we can draw the stylized exact geometry:

# Let's draw:
# 1. Top text: "قائم"
draw.text((260, 80), "قائم", fill=text_color, font=font_large, anchor="mm")

# 2. Letter "و" in stylized circular badge / text
draw.text((700, 480), "و", fill=w_color, font=font_w, anchor="mm")

# 3. Bottom text: "رف"
draw.text((320, 720), "رف", fill=text_color, font=font_large, anchor="mm")

# Save watermark image
os.makedirs('public/_fixed', exist_ok=True)
watermark.save('public/_fixed/watermark.png', 'PNG')
print("Saved public/_fixed/watermark.png successfully!")
