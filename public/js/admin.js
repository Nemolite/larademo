/**
 * Удаление категории
 * @type {NodeListOf<Element>}
 */
let deletecategory = document.querySelectorAll('.deletecategory')
deletecategory.forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault()
        let formData = new FormData(item.parentElement)
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result_output").innerHTML = "Категория удалена";
            }
            else {
                document.getElementById("result_output").innerHTML = "Эту категорию нельзя удалить. Имеются товары";
            }
        };
        xhr.open("POST", "/deletecategory");
        xhr.send(formData);
    });
})

/**
 * Изменение статуса в админке
 * @type {NodeListOf<Element>}
 */
let formstatus = document.querySelectorAll('.formstatus')
formstatus.forEach(item => {
    item.addEventListener("change", function (e) {
        e.preventDefault()
        let formData = new FormData(item)
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                console.log("Статус заказа изменен");

            }
            else {
                console.log("Что-то пошло не так");
            }
        };
        xhr.open("POST", "/adminorders");
        xhr.send(formData);
    });
})
