document.addEventListener('DOMContentLoaded', () => {

    // const createTodoForm = document.getElementById('task__form');

    //  createTodoForm.addEventListener('submit', async function(event) {
    //     event.preventDefault();

    //     const title = document.querySelector('#title').value;
    //     const description = document.querySelector('#description').value;

    //     if (title.trim() !== '' && description.trim() !== '') {
    //         const todoObject = {
    //             "title": title,
    //             "completed": "0", 
    //             "description": description
    //         };

    //         try {
    //             const todo = JSON.stringify(todoObject);
    //             await createTodo(todo);
    //         } catch (error) {
    //             console.error("ERROR CREATING TODO", error);
    //         }
    //     }
    // });

    // async function createTodo(todo) {
    //     try {
    //         const response = await fetch('http://127.0.0.1/Todo-php-app/backend/endpoints/create.php', {
    //             method: 'POST',
    //             headers: {
    //                 'Content-Type': 'application/json',
    //             },
    //             body: todo
    //         });

    //         if (!response.ok) {
    //             throw new Error(`HTTP error! status: ${response.status}`);
    //         }

    //         const data = await response.json();

    //         if (data.success) {
    //             getAllTasks(); // Refresh the task list after adding a new task
    //         } else {
    //             console.error(data.error);
    //         }

    //     } catch (error) {
    //         console.error("ERROR ADDING TODO", error);
    //     }
    // }


    async function getAllTasks() {
        try {
            const response = await axios.get('http://127.0.0.1/Todo-php-app/backend/endpoints/list-all.php');
            console.log(response.data);
            renderTasks(response.data)
          } catch (error) {
            console.error(error);
          }
    }
    
    async function getActiveTasks() {
        try {
            const response = await axios.get('http://127.0.0.1/Todo-php-app/backend/endpoints/list-active.php');
            renderTasks(response.data)
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
                            <input value="true" type="checkbox" name="complete" id="complete">
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
    countActive();
})


