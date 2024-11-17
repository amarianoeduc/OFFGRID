window.addEventListener('load', function () {
    var preloader = document.querySelector('.preloader');
    preloader.style.opacity = '0';
    setTimeout(function () {
       preloader.style.display = 'none';
    }, 1100);
 
    document.querySelector('.content').style.display = 'block';
 });