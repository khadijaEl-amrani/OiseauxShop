document.addEventListener('DOMContentLoaded', function() {
    const imageInput = document.getElementById('images');
    const previewContainer = document.getElementById('image-previews');
    
    if (imageInput && previewContainer) {
        imageInput.addEventListener('change', function() {
            // Clear previous previews
            previewContainer.innerHTML = '';
            
            // Check if files were selected
            if (this.files && this.files.length > 0) {
                // Create row for previews
                const row = document.createElement('div');
                row.className = 'row mt-3';
                previewContainer.appendChild(row);
                
                // Loop through each file
                Array.from(this.files).forEach(file => {
                    if (file.type.match('image.*')) {
                        const reader = new FileReader();
                        
                        reader.onload = function(e) {
                            // Create column
                            const col = document.createElement('div');
                            col.className = 'col-4 col-md-3 mb-3';
                            
                            // Create image
                            const img = document.createElement('img');
                            img.src = e.target.result;
                            img.className = 'img-thumbnail';
                            img.style = 'height: 150px; width: 100%; object-fit: cover;';
                            
                            // Append image to column and column to row
                            col.appendChild(img);
                            row.appendChild(col);
                        };
                        
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    }
});