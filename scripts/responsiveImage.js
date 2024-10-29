// responsiveImage.js

function updateImages() {
    var images = document.querySelectorAll('.responsive-image'); // Select all images with the class 'responsive-image'
    
    images.forEach(function(img) {
        var baseName = img.getAttribute('data-base-name');
        if (window.innerWidth <= 800) {
            img.src = './images/' + baseName + 'Mobile.png';
        } else {
            img.src = './images/' + baseName + 'Desktop.png';
        }
    });
}

// Call the function when the page loads
updateImages();

// Add an event listener to handle window resizing
window.addEventListener('resize', updateImages);
