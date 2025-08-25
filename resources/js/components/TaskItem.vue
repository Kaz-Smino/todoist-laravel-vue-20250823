<template>
  <div
    class="flex items-center justify-between p-4 border border-gray-200 rounded-lg"
    :class="{ 'bg-gray-50': task.completed }"
  >
    <div class="flex items-center space-x-3 flex-1">
      <input
        type="checkbox"
        :checked="task.completed"
        @change="$emit('toggle', task)"
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
    <div class="flex space-x-2">
      <button
        @click="$emit('edit', task)"
        class="text-blue-500 hover:text-blue-700 font-medium px-3 py-1 rounded transition-colors"
      >
        Edit
      </button>
      <button
        @click="$emit('delete', task.id)"
        class="text-red-500 hover:text-red-700 font-medium px-3 py-1 rounded transition-colors"
      >
        Delete
      </button>
    </div>
  </div>
</template>

<script>
export default {
  name: 'TaskItem',
  props: {
    task: {
      type: Object,
      required: true
    }
  },
  emits: ['toggle', 'edit', 'delete']
}
</script>