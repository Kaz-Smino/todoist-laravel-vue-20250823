<template>
  <div class="max-w-4xl mx-auto p-6">
    <header class="mb-8">
      <h1 class="text-3xl font-bold text-gray-800">Todo App</h1>
    </header>

    <!-- Add Task Form -->
    <div class="bg-white rounded-lg shadow-md p-6 mb-6">
      <h2 class="text-xl font-semibold mb-4">Add New Task</h2>
      <form @submit.prevent="addTask" class="space-y-4">
        <div>
          <input
            v-model="newTask.title"
            type="text"
            placeholder="Task title"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          >
        </div>
        <div>
          <textarea
            v-model="newTask.description"
            placeholder="Task description (optional)"
            rows="3"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          ></textarea>
        </div>
        <button
          type="submit"
          class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition-colors"
        >
          Add Task
        </button>
      </form>
    </div>

    <!-- Tasks List -->
    <div class="bg-white rounded-lg shadow-md p-6">
      <h2 class="text-xl font-semibold mb-4">Tasks</h2>
      
      <div v-if="loading" class="text-center py-4">
        <span class="text-gray-500">Loading...</span>
      </div>
      
      <div v-else-if="tasks.length === 0" class="text-center py-8">
        <span class="text-gray-500">No tasks yet. Add one above!</span>
      </div>
      
      <div v-else class="space-y-3">
        <div
          v-for="task in tasks"
          :key="task.id"
          class="flex items-center justify-between p-4 border border-gray-200 rounded-lg"
          :class="{ 'bg-gray-50': task.completed }"
        >
          <div class="flex items-center space-x-3 flex-1">
            <input
              type="checkbox"
              :checked="task.completed"
              @change="toggleTask(task)"
              class="h-5 w-5 text-blue-600 rounded focus:ring-blue-500"
            >
            <div class="flex-1">
              <h3
                class="font-medium"
                :class="{ 'line-through text-gray-500': task.completed, 'text-gray-800': !task.completed }"
              >
                {{ task.title }}
              </h3>
              <p
                v-if="task.description"
                class="text-sm mt-1"
                :class="{ 'text-gray-400': task.completed, 'text-gray-600': !task.completed }"
              >
                {{ task.description }}
              </p>
            </div>
          </div>
          <button
            @click="deleteTask(task.id)"
            class="text-red-500 hover:text-red-700 font-medium px-3 py-1 rounded transition-colors"
          >
            Delete
          </button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskApp',
  data() {
    return {
      tasks: [],
      loading: true,
      newTask: {
        title: '',
        description: '',
        completed: false
      }
    }
  },
  mounted() {
    this.fetchTasks();
  },
  methods: {
    async fetchTasks() {
      try {
        const response = await fetch('/api/tasks');
        this.tasks = await response.json();
      } catch (error) {
        console.error('Error fetching tasks:', error);
      } finally {
        this.loading = false;
      }
    },
    async addTask() {
      try {
        const response = await fetch('/api/tasks', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(this.newTask)
        });
        
        if (response.ok) {
          const newTask = await response.json();
          this.tasks.push(newTask);
          this.newTask = { title: '', description: '', completed: false };
        }
      } catch (error) {
        console.error('Error adding task:', error);
      }
    },
    async toggleTask(task) {
      try {
        const response = await fetch(`/api/tasks/${task.id}`, {
          method: 'PUT',
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify({
            ...task,
            completed: !task.completed
          })
        });
        
        if (response.ok) {
          const updatedTask = await response.json();
          const index = this.tasks.findIndex(t => t.id === task.id);
          this.tasks[index] = updatedTask;
        }
      } catch (error) {
        console.error('Error updating task:', error);
      }
    },
    async deleteTask(taskId) {
      if (!confirm('Are you sure you want to delete this task?')) {
        return;
      }
      
      try {
        const response = await fetch(`/api/tasks/${taskId}`, {
          method: 'DELETE',
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          }
        });
        
        if (response.ok) {
          this.tasks = this.tasks.filter(task => task.id !== taskId);
        }
      } catch (error) {
        console.error('Error deleting task:', error);
      }
    }
  }
}
</script>