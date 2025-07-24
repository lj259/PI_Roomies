# Profile Picture Upload Feature

This feature allows users to upload profile pictures during registration and when editing their profile.

## Features Implemented

### 1. Registration Form
- Users can upload a profile picture during registration
- The picture preview is shown immediately after selection
- If no picture is uploaded, a default image is used
- Supports JPG, PNG, and JPEG formats (max 2MB)

### 2. Profile Edit Modal
- Users can change their profile picture from the profile page
- Click the camera icon to select a new image
- Preview is shown before saving
- Old profile pictures are automatically deleted when replaced

### 3. Profile Display
- Profile pictures are displayed in a circular format
- Fallback to default image if no profile picture exists
- Hover effects for better user interaction

## Technical Implementation

### Files Modified

1. **Controller**: `app/Http/Controllers/usuariosController.php`
   - Updated `registrar()` method to handle file uploads
   - Updated `updateProfile()` method to handle profile picture updates
   - Added proper file validation and storage handling

2. **Views**: 
   - `resources/views/usuarios/Registro/RegistroUsuario.blade.php` - Registration form
   - `resources/views/usuarios/Perfil.blade.php` - Profile page and edit modal

3. **CSS**: `public/css/perfil.css`
   - Added avatar upload styles
   - Camera icon styling
   - Hover effects and transitions

4. **Form Requests**: 
   - `app/Http/Requests/RegistroUsuarioRequest.php` - Registration validation
   - `app/Http/Requests/UpdateProfileRequest.php` - Profile update validation

5. **Database Seeder**: `database/seeders/usuarioSeeder.php`
   - Added default profile pictures for existing users

### Storage Structure

```
storage/app/public/
└── perfil/
    ├── default.jpg (default profile picture)
    └── [user_uploads].jpg/png/jpeg
```

### Validation Rules

- **File Types**: jpg, png, jpeg
- **Max Size**: 2MB
- **Required**: No (optional for both registration and profile update)

## Usage Instructions

### For Registration:
1. Fill out the registration form
2. Click the camera icon to upload a profile picture (optional)
3. Preview will show immediately
4. Complete registration

### For Profile Updates:
1. Go to your profile page
2. Click "Edit" button
3. In the modal, click the camera icon to change your picture
4. Preview will show immediately
5. Save changes

## File Management

- Profile pictures are stored in `storage/app/public/perfil/`
- Old pictures are automatically deleted when replaced
- Default picture is used as fallback
- Storage link must be created: `php artisan storage:link`

## Error Handling

- File size validation (max 2MB)
- File type validation (only images)
- Storage error handling
- Fallback to default image if upload fails
