let catRemover = document.querySelectorAll('.blog__del');
catRemover.forEach(function (item) {
    item.addEventListener('click', function (e) {
        e.preventDefault();
        let value = e.currentTarget.value;
        $.ajax({
            url: './pages/categorie-remover.php',
            type: 'GET',
            data: {
                id: `${value}`,
            }, success: () => {
                window.location.href = "./index.php";
            }
        });
    })
});
let catSearch = document.querySelector('.blog__search_btn');
if (catSearch) {
    catSearch.addEventListener('click', function (e) {
        e.preventDefault();
        let value = this.value;
        $.ajax({
            url: './pages/sort-cat.php',
            type: 'GET',
            data: {
                'tempId': `${value}`
            }, success: function (data) {
                window.location.href = "./pages/sort.php";
            }
        })

    })
}

