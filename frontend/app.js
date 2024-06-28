document.addEventListener('DOMContentLoaded', () => {

    async function getAllTasks() {
        try {
            const response = await fetch('http://127.0.0.1/Todo-php-app/backend/apis/list-all.php');
            const todos = await response.json();
            renderTasks(todos)
        } catch(error) {
            console.error("ERROR GETTING TODO", error);
        }
    }
    
    async function getActiveTasks() {
        try {
            const response = await fetch('http://127.0.0.1/Todo-php-app/backend/apis/list-active.php');
            const ActiveTodos = await response.json();
            renderTasks(ActiveTodos);
        } catch(error) {
            console.log("ERROR GETTING ACTIVE TODO", error);
        }
    }


    async function countActive() {
        try {
            const response = await fetch('http://127.0.0.1/Todo-php-app/backend/apis/count-active.php');
            const ActiveTodos = await response.json();
            document.querySelector('.Active_todo').textContent = ActiveTodos.data.Active;
        } catch(error) {
            console.log("ERROR GETTING ACTIVE TODO", error);
        }
    }

    countActive()
    
    //render tasks in the front-end
    function renderTasks(todo) {

        const todos = todo.data
        const todoContainer = document.querySelector('.todo__container');
        todoContainer.innerHTML = '';
      
        todos.forEach(todo => {
            const todoElement = `
                <div  class="todo">
                    <div class="todo__title">
                        <div class="todo__title__item">
                            <input value="true" type="checkbox" name="completed" id="completed">
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
    
    document.querySelector('.active__todo').addEventListener('click', getActiveTasks);
    
    //CREATE NEW TODO
    const newTodoBtn = document.querySelector('.new__todo');
    const taskForm = document.querySelector('#task__form');
    
    newTodoBtn.addEventListener('click', () => {
        taskForm.style.display = "block";
    });
    
    document.querySelector('.close').addEventListener('click', () => {
        taskForm.style.display = "none";
    });

    getAllTasks();
})


