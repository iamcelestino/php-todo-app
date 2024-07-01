
document.addEventListener('DOMContentLoaded', () => {

    const createTodoForm = document.getElementById('task__form');

     createTodoForm.addEventListener('submit', async function(event) {

        event.preventDefault();

        let completed = "0"; //default todo status is false/ not completed
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
            })

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

    //render tasks in the front-end
    function renderTasks(todo) {

        const todos = todo.data
        const todoContainer = document.querySelector('.todo__container');
        todoContainer.innerHTML = '';
      
        todos.forEach(todo => {
            var todoElement = `
                <div class="todo">
                    <div class="todo__title">
                        <div class="todo__title__item">
                            <input value="true" type="checkbox" name="complete" id="complete">
                            <p class="title">${todo.title}</p>
                        </div>
                        <ion-icon class="${todo.id}" id="${todo.id}" name="close-circle"></ion-icon>
                    </div>
                    <p class="description">${todo.description}</p>
                </div>
            `
            todoContainer.innerHTML += todoElement;
        });

    }
    

    document.querySelector('.todo__container').addEventListener('click', event => {
        deleteTodo(event.target.id);
    })

    document.querySelector('.active__todo').addEventListener('click', getActiveTasks);
    document.querySelector('.completed__todo').addEventListener('click', getCompletedTasks);
    
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
    countActive()
})


