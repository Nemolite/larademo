console.log(111)
$('.slider').slick({
    dots: true,
    autoplay: true,
    infinite: true,
    speed: 300,
    slidesToShow: 1,
    adaptiveHeight: true
});


let formsort = document.querySelector('.formsort')
formsort.addEventListener("change", function (e) {
        e.preventDefault()
        let formData = new FormData(formsort)
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log("Удачная сортировка");
            }
            else {
                console.log("Что-то пошло не так");
            }
        };
        xhr.open("POST", "/");
        xhr.send(formData);
    });

