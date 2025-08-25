<template>
  <div class="max-w-2xl mx-auto p-6">
    <header class="mb-6">
      <h1 class="text-3xl font-bold text-gray-800">
        {{ isEditing ? 'Edit Task' : 'Create New Task' }}
      </h1>
    </header>

    <div class="bg-white rounded-lg shadow-md p-6">
      <form @submit.prevent="handleSubmit" class="space-y-4">
        <div>
          <label for="title" class="block text-sm font-medium text-gray-700 mb-2">
            Task Title *
          </label>
          <input
            id="title"
            v-model="formData.title"
            type="text"
            placeholder="Enter task title"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
            required
          >
        </div>
        
        <div>
          <label for="description" class="block text-sm font-medium text-gray-700 mb-2">
            Description
          </label>
          <textarea
            id="description"
            v-model="formData.description"
            placeholder="Enter task description (optional)"
            rows="4"
            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"
          ></textarea>
        </div>
        
        <div class="flex items-center">
          <input
            id="completed"
            v-model="formData.completed"
            type="checkbox"
            class="h-4 w-4 text-blue-600 rounded focus:ring-blue-500"
          >
          <label for="completed" class="ml-2 text-sm text-gray-700">
            Mark as completed
          </label>
        </div>
        
        <div class="flex space-x-4 pt-4">
          <button
            type="submit"
            class="bg-blue-500 hover:bg-blue-600 text-white font-medium py-2 px-6 rounded-md transition-colors"
            :disabled="loading"
          >
            {{ loading ? 'Saving...' : (isEditing ? 'Update Task' : 'Create Task') }}
          </button>
          
          <router-link
            to="/"
            class="bg-gray-500 hover:bg-gray-600 text-white font-medium py-2 px-6 rounded-md transition-colors inline-block"
          >
            Cancel
          </router-link>
        </div>
      </form>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskForm',
  data() {
    return {
      formData: {
        title: '',
        description: '',
        completed: false
      },
      loading: false,
      isEditing: false,
      taskId: null
    }
  },
  async mounted() {
    // Check if we're editing an existing task
    if (this.$route.params.id) {
      this.isEditing = true;
      this.taskId = this.$route.params.id;
      await this.fetchTask();
    }
  },
  methods: {
    async fetchTask() {
      try {
        this.loading = true;
        const response = await fetch(`/api/tasks/${this.taskId}`);
        if (response.ok) {
          this.formData = await response.json();
        } else {
          alert('Task not found');
          this.$router.push('/');
        }
      } catch (error) {
        console.error('Error fetching task:', error);
        alert('Error loading task');
      } finally {
        this.loading = false;
      }
    },
    
    async handleSubmit() {
      try {
        this.loading = true;
        
        const url = this.isEditing ? `/api/tasks/${this.taskId}` : '/api/tasks';
        const method = this.isEditing ? 'PUT' : 'POST';
        
        const response = await fetch(url, {
          method: method,
          headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          body: JSON.stringify(this.formData)
        });
        
        if (response.ok) {
          this.$router.push('/');
        } else {
          alert('Error saving task');
        }
      } catch (error) {
        console.error('Error saving task:', error);
        alert('Error saving task');
      } finally {
        this.loading = false;
      }
    }
  },
  
  watch: {
    '$route'() {
      // Reset form when route changes
      if (this.$route.params.id) {
        this.isEditing = true;
        this.taskId = this.$route.params.id;
        this.fetchTask();
      } else {
        this.isEditing = false;
        this.taskId = null;
        this.formData = { title: '', description: '', completed: false };
      }
    }
  }
}
</script>