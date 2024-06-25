
async function getTasks() {
    
    try {
        const response = await fetch('http://127.0.0.1/Todo-php-app/backend/apis/list-all.php')
        const todos = await response.json();
        renderTasks(todos)
    } catch(error) {
        console.error("ERROR GETTING TODO", error);
    }

}

function renderTasks(todo) {
    const todos = todo.data
    const todoContainer = document.querySelector('.todo__container');
  
    todos.forEach(todo => {
        const todoElement = `
            <div  class="todo">
                <div class="todo__title">
                    <div class="todo__title__item">
                        <input value="true" type="radio" name="completed" id="completed">
                        <p class="title">${todo.title}</p>
                    </div>
                    <ion-icon name="close-circle"></ion-icon>
                </div>
                <p class="description">${todo.description}</p>
            </div>
        `
        todoContainer.innerHTML += todoElement;
    });

}

document.addEventListener('DOMContentLoaded', getTasks);


