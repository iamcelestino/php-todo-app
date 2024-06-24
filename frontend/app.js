
function getTasks() {
    fetch('http://127.0.0.1/Todo-php-app/backend/apis/list-all.php')
        .then(response => response.json())
        .then(tasks => {
            console.log(tasks)
        });
}

getTasks();