<style>
    .profile-container {
        padding: 4rem 0;
        background-color: #FDFCF5;
        min-height: 80vh;
    }

    .profile-wrapper {
        display: flex;
        gap: 2rem;
        align-items: flex-start;
    }

    /* Sidebar Styling */
    .profile-sidebar {
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        width: 280px;
        flex-shrink: 0;
        overflow: hidden;
    }

    .user-info {
        padding: 2rem;
        text-align: center;
        border-bottom: 1px solid #E8F5E9;
        background: linear-gradient(135deg, #1c4dad 0%, #3066d1 100%);
        color: white;
    }

    .user-avatar {
        width: 80px;
        height: 80px;
        margin: 0 auto 1rem;
        background: rgba(255,255,255,0.2);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2rem;
        font-weight: bold;
        color: white;
        overflow: hidden;
        border: 3px solid rgba(255,255,255,0.3);
    }

    .user-avatar img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .user-info h4 {
        margin: 0;
        font-size: 1.1rem;
        font-weight: 600;
    }

    .user-info p {
        margin: 0.25rem 0 0;
        font-size: 0.85rem;
        opacity: 0.9;
    }

    .profile-menu {
        list-style: none;
        padding: 1rem 0;
        margin: 0;
    }

    .profile-menu li a {
        display: flex;
        align-items: center;
        gap: 1rem;
        padding: 1rem 1.5rem;
        color: #4a5568;
        text-decoration: none;
        transition: all 0.3s;
        border-right: 3px solid transparent; /* RTL default */
    }
    
    html[dir="rtl"] .profile-menu li a {
         border-right: 3px solid transparent;
         border-left: none;
    }
    html[dir="ltr"] .profile-menu li a {
         border-left: 3px solid transparent;
         border-right: none;
    }

    .profile-menu li.active a,
    .profile-menu li a:hover {
        background-color: #E8F5E9;
        color: #1c4dad;
        border-color: #1c4dad;
    }

    /* Content Styling */
    .profile-content {
        flex: 1;
        background: white;
        border-radius: 16px;
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        padding: 2.5rem;
    }

    .content-header {
        margin-bottom: 2rem;
        border-bottom: 1px solid #E8F5E9;
        padding-bottom: 1rem;
    }

    .content-header h3 {
        color: #2d3748;
        font-weight: 700;
        margin-bottom: 0.5rem;
    }

    .content-header p {
        color: #718096;
    }
    
    .form-group {
        margin-bottom: 1.5rem;
    }

    .form-group label {
        display: block;
        margin-bottom: 0.5rem;
        color: #4a5568;
        font-weight: 600;
        font-size: 0.9rem;
    }
    
    .input-wrapper {
        position: relative;
    }
    
    .input-wrapper i {
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        left: 1rem;
        color: #a0aec0;
    }
    
    html[dir="rtl"] .input-wrapper i {
        left: auto;
        right: 1rem;
    }
    
    .input-wrapper input {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        transition: all 0.3s;
        color: #2d3748;
    }
    
    html[dir="rtl"] .input-wrapper input {
        padding: 0.75rem 3rem 0.75rem 1rem;
    }
    
    .input-wrapper input:focus {
        border-color: #1c4dad;
        outline: none;
        box-shadow: 0 0 0 3px rgba(28, 77, 173, 0.1);
    }

    .save-btn {
        background: linear-gradient(135deg, #1c4dad 0%, #3066d1 100%);
        color: white;
        border: none;
        padding: 0.8rem 2rem;
        border-radius: 10px;
        font-weight: 600;
        cursor: pointer;
        transition: transform 0.2s;
        margin-top: 1rem;
    }

    .save-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 6px rgba(28, 77, 173, 0.25);
    }

    @media (max-width: 900px) {
        .profile-wrapper {
            flex-direction: column;
        }
        .profile-sidebar {
            width: 100%;
        }
    }
    
    /* Alerts */
     .alert-success {
        color: #155724;
        background-color: #d4edda;
        border-color: #c3e6cb;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: .25rem;
    }
    
    .invalid-feedback {
        color: #e53e3e;
        font-size: 0.875rem;
        margin-top: 0.3rem;
        display: block;
    }

    .custom-select {
        width: 100%;
        padding: 0.75rem 1rem 0.75rem 3rem;
        border: 2px solid #e2e8f0;
        border-radius: 10px;
        appearance: none;
        background-color: white;
        color: #2d3748;
        cursor: pointer;
    }
    
    html[dir="rtl"] .custom-select {
        padding: 0.75rem 3rem 0.75rem 1rem;
    }

    .alert-danger {
        color: #721c24;
        background-color: #f8d7da;
        border-color: #f5c6cb;
        padding: .75rem 1.25rem;
        margin-bottom: 1rem;
        border-radius: .25rem;
    }
    
    .text-primary { color: #1c4dad !important; }

    /* Shared Profile Button Styles */
    .btn-outline-primary { color: #1c4dad; border-color: #1c4dad; }
    .btn-outline-primary:hover { background-color: #1c4dad; border-color: #1c4dad; color: white; }
    .btn-primary { background-color: #1c4dad; border-color: #1c4dad; color: white; }
    .btn-primary:hover { background-color: #3066d1; border-color: #3066d1; }

    /* Shared Badge Styles */
    .badge-status { padding: 0.5em 1em; font-size: 0.75em; letter-spacing: 0.5px; }
    .badge-status.pending { background-color: #fffaf0; color: #b7791f; border: 1px solid #fbd38d; }
    .badge-status.processing { background-color: #e6fffa; color: #319795; border: 1px solid #81e6d9; }
    .badge-status.completed, .badge-status.delivered { background-color: #f0fff4; color: #1c4dad; border: 1px solid #9ae6b4; }
    .badge-status.cancelled { background-color: #fff5f5; color: #c53030; border: 1px solid #feb2b2; }
    .badge-status.shipped { background-color: #E8F5E9; color: #143d23; border: 1px solid #3066d1; } /* Updated from blue */
</style>
