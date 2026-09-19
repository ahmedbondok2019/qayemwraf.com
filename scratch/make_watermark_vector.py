import os
from PIL import Image, ImageDraw, ImageFont, ImageFilter

def create_qayem_watermark():
    # Canvas size for watermark
    W, H = 800, 1000
    img = Image.new('RGBA', (W, H), (0, 0, 0, 0))
    draw = ImageDraw.Draw(img)

    # Grey color matching reference: RGBA(140, 150, 165, 230)
    c_grey = (145, 155, 170, 240)
    c_white = (255, 255, 255, 230)
    
    # ------------------ TOP: قائم ------------------
    # Dots of Qaf (top right)
    draw.rounded_rectangle([520, 80, 580, 140], radius=15, fill=c_grey)
    draw.rounded_rectangle([600, 80, 660, 140], radius=15, fill=c_grey)
    
    # Qaf loop + Alef + Yeh + Meem main body
    # Main horizontal bar connecting base
    draw.rounded_rectangle([180, 280, 680, 360], radius=20, fill=c_grey)
    
    # Alef vertical pillar
    draw.rounded_rectangle([420, 80, 480, 360], radius=20, fill=c_grey)
    
    # Qaf right vertical side
    draw.rounded_rectangle([620, 150, 680, 360], radius=20, fill=c_grey)
    # Qaf top bridge
    draw.rounded_rectangle([500, 150, 680, 210], radius=20, fill=c_grey)
    
    # Meem left side & loop
    draw.rounded_rectangle([180, 150, 320, 360], radius=25, fill=c_grey)
    # Cutout inside meem
    draw.rounded_rectangle([230, 200, 270, 290], radius=10, fill=(0, 0, 0, 0))
    # Meem left tail
    draw.rounded_rectangle([180, 340, 240, 490], radius=20, fill=c_grey)
    
    # Two dots under Yeh (below top bar)
    draw.rounded_rectangle([340, 380, 390, 430], radius=12, fill=c_grey)
    draw.rounded_rectangle([340, 440, 390, 490], radius=12, fill=c_grey)

    # ------------------ RIGHT: و ------------------
    # The stylized "و" / 9 shape
    # Outer circle for "و" head
    draw.ellipse([540, 420, 720, 600], fill=c_white)
    # Inner hole
    draw.ellipse([595, 475, 665, 545], fill=(0, 0, 0, 0))
    # "و" tail swooping down-left
    draw.rounded_rectangle([650, 510, 720, 690], radius=25, fill=c_white)
    draw.rounded_rectangle([570, 640, 710, 695], radius=20, fill=c_white)

    # ------------------ BOTTOM: رف ------------------
    # Dot above Feh
    draw.rounded_rectangle([250, 490, 300, 540], radius=12, fill=c_grey)
    
    # Raa vertical long pillar on right
    draw.rounded_rectangle([420, 550, 480, 870], radius=25, fill=c_grey)
    
    # Feh body & loop on left
    draw.rounded_rectangle([180, 550, 360, 750], radius=35, fill=c_grey)
    # Cutout inside feh
    draw.rounded_rectangle([235, 605, 305, 695], radius=15, fill=(0, 0, 0, 0))

    # Save clean watermark
    os.makedirs('public/_fixed', exist_ok=True)
    img.save('public/_fixed/watermark.png', 'PNG')
    print("Generated public/_fixed/watermark.png")
    return img

def apply_watermark_to_image(img_path, watermark_img, output_path, target_opacity=0.32):
    base = Image.open(img_path).convert('RGBA')
    bw, bh = base.size
    
    # Target watermark size: 60% of base image width or height
    wm_ratio = min(bw * 0.55 / watermark_img.width, bh * 0.65 / watermark_img.height)
    new_w = int(watermark_img.width * wm_ratio)
    new_h = int(watermark_img.height * wm_ratio)
    
    wm_resized = watermark_img.resize((new_w, new_h), Image.Resampling.LANCZOS)
    
    # Adjust opacity
    wm_data = wm_resized.getdata()
    adjusted_data = []
    for item in wm_data:
        # item is (R, G, B, A)
        adjusted_data.append((item[0], item[1], item[2], int(item[3] * target_opacity)))
    wm_resized.putdata(adjusted_data)
    
    # Center position
    pos_x = (bw - new_w) // 2
    pos_y = (bh - new_h) // 2
    
    # Paste with alpha
    base.paste(wm_resized, (pos_x, pos_y), wm_resized)
    
    # Convert to RGB and save as JPEG / WebP
    base.convert('RGB').save(output_path, quality=90)
    print("Saved watermarked test image:", output_path)

wm = create_qayem_watermark()
if os.path.exists('scratch/sample1.jpeg'):
    apply_watermark_to_image('scratch/sample1.jpeg', wm, 'scratch/watermarked_sample.jpg')
