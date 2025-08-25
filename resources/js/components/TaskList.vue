<template>
  <div class="max-w-4xl mx-auto p-6">
    <header class="mb-8 flex justify-between items-center">
      <h1 class="text-3xl font-bold text-gray-800">Task Manager</h1>
      <router-link
        to="/new"
        class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition-colors"
      >
        Add New Task
      </router-link>
    </header>

    <div class="bg-white rounded-lg shadow-md p-6">
      <h2 class="text-xl font-semibold mb-4">Your Tasks</h2>
      
      <div v-if="loading" class="text-center py-8">
        <span class="text-gray-500">Loading tasks...</span>
      </div>
      
      <div v-else-if="tasks.length === 0" class="text-center py-8">
        <p class="text-gray-500 mb-4">No tasks yet. Create your first task!</p>
        <router-link
          to="/new"
          class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-4 rounded-md transition-colors inline-block"
        >
          Create Task
        </router-link>
      </div>
      
      <div v-else class="space-y-3">
        <TaskItem
          v-for="task in tasks"
          :key="task.id"
          :task="task"
          @toggle="toggleTask"
          @edit="editTask"
          @delete="deleteTask"
        />
      </div>
    </div>
  </div>
</template>

<script>
import TaskItem from './TaskItem.vue'

export default {
  name: 'TaskList',
  components: {
    TaskItem
  },
  data() {
    return {
      tasks: [],
      loading: true
    }
  },
  mounted() {
    this.fetchTasks();
  },
  methods: {
    async fetchTasks() {
      try {
        this.loading = true;
        const response = await fetch('/api/tasks');
        this.tasks = await response.json();
      } catch (error) {
        console.error('Error fetching tasks:', error);
      } finally {
        this.loading = false;
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
    
    editTask(task) {
      this.$router.push(`/edit/${task.id}`);
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