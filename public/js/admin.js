let deletecategory = document.querySelectorAll('.deletecategory')

deletecategory.forEach(item => {
    item.addEventListener('click', function (e) {
        e.preventDefault()
        let formData = new FormData(item.parentElement)
        let xhr = new XMLHttpRequest();
        xhr.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("result_output").innerHTML = this.responseText;
            }
            else {
                document.getElementById("result_output").innerHTML = "Эту категорию нельзя удалить. Имеются товары";
            }
        };
        xhr.open("POST", "/deletecategory");
        xhr.send(formData);
    });
})
