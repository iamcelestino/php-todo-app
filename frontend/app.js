document.addEventListener('DOMContentLoaded', () => {

    const createTodoForm = document.getElementById('task__form');
    const todoContainer = document.querySelector('.todo__container');
    
     createTodoForm.addEventListener('submit', async function(event) {
        event.preventDefault();
        let completed = "0"; 
        const title = document.querySelector('#title').value;
        const description = document.querySelector('#description').value;
        const formData = {
            title: title,
            completed: completed,
            description: description
        }
        try{
            const todo = JSON.stringify(formData);
            const {data} = await axios.post('http://127.0.0.1/Todo-php-app/backend/endpoints/create.php', todo, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
        } catch(error) {
            console.log("ERROR CREATING TODO");
        }
    });

    async function getAllTasks() {
        try {
            const response = await axios.get('http://127.0.0.1/Todo-php-app/backend/endpoints/list-all.php');
            renderTasks(response.data)
          } catch (error) {
            console.error(error);
          }
    }

    async function getActiveTasks() {
        try {
            const response = await axios.get('http://127.0.0.1/Todo-php-app/backend/endpoints/list-active.php');
            renderTasks(response.data);
          } catch (error) {
            console.error(error);
          }
    }

    async function getCompletedTasks() {
        try {
            const response = await axios.get('http://127.0.0.1/Todo-php-app/backend/endpoints/list-completed.php');
            renderTasks(response.data);
          } catch (error) {
            console.error(error);
          }
    }

    async function markCompleted(id, completed) {
        try {
            const response = await axios.patch(`http://127.0.0.1/Todo-php-app/backend/endpoints/markCompleted.php?id=${id}`, {
                completed: completed
            }, {
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            console.log(response.data);
        } catch(error) {
            console.log("COULD NOT MARK AS COMPLETED", error);
        }
    }

    async function countActive() {
        try {
            const response = await axios('http://127.0.0.1/Todo-php-app/backend/endpoints/count-active.php');
            const ActiveTodos = await response.data;
            document.querySelector('.Active_todo').textContent = ActiveTodos.data.Active;
        } catch(error) {
            console.log("ERROR GETTING ACTIVE TODO", error);
        }
    }

    async function deleteTodo(id) {
        try {
            const response = await axios.delete('http://127.0.0.1/Todo-php-app/backend/endpoints/delete.php', {
                params: {
                    id: id
                }
            });
            console.log(response.data);
        } catch(error) {
            console.error("ERROR DELETING TODO", error);
        }
    }

    async function deleteCompletedTodo() {
        try {
            const response = await axios.delete('http://127.0.0.1/Todo-php-app/backend/endpoints/deleteCompleted.php');
            console.log(response.data);
        } catch(error) {
            console.error("ERROR DELETING TODO", error);
        }
    }

    function renderTasks(todo) {
        const todos = todo.data
        todoContainer.innerHTML = '';
        todos.forEach(todo => {
            const todoElement = `
                <div class="todo ${todo.completed}">
                    <div class="todo__title">
                        <div class="todo__title__item">
                            <img src="./images/icon-check.svg" id="${todo.id}"  alt="">
                            <p class="title">${todo.title}</p>
                        </div>
                        <ion-icon id="${todo.id}" name="close-circle"></ion-icon>
                    </div>
                    <p class="description">${todo.description}</p>
                </div>
            `
            todoContainer.innerHTML += todoElement;
        });

        Array.from(todoContainer.children).forEach(child => {
            if(child.classList.contains("1")) {
                const img = child.firstElementChild.firstElementChild.firstElementChild
                img.style.backgroundColor = "rgb(0, 110, 255)";
            }
        });
    }

    todoContainer.addEventListener('click', event => {
        const element = event.target;
        const todoStatus= {completed: "1"}
        const updateActive = JSON.stringify(todoStatus);

        switch (element.tagName) {
            case 'DIV':
                element.nextElementSibling.style.display = 'block';
                break;
            case 'P':
              element.parentElement.parentElement.nextElementSibling.style.display = 'block'
              break;
            case 'IMG':
                element.style.backgroundColor = 'rgb(0, 110, 255)';
                markCompleted(element.id, updateActive);
              break;
            case 'ION-ICON':
                deleteTodo(element.id);
              break;
            default:
              alert( "I don't know such values" );
          }
    });

    document.querySelector('.clear__completed').addEventListener('click', deleteCompletedTodo)
    document.querySelectorAll('.all__todo').forEach(item => item.addEventListener('click', getAllTasks))

    document.querySelectorAll('.active__todo').forEach(item => {
        item.addEventListener('click', getActiveTasks);
    })


    document.querySelectorAll('.completed__todo').forEach(item => item.addEventListener('click', getCompletedTasks));
    
    const newTodoBtn = document.querySelector('.new__todo');
    const taskForm = document.querySelector('#task__form');
    
    newTodoBtn.addEventListener('click', () => {
        taskForm.style.display = "block";
    });
    
    document.querySelector('.close').addEventListener('click', () => {
        taskForm.style.display = "none";
    });

    getAllTasks();
    countActive();
})


