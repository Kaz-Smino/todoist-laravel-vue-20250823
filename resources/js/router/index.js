import { createRouter, createWebHistory } from 'vue-router'
import TaskList from '../components/TaskList.vue'
import TaskForm from '../components/TaskForm.vue'
import TestComponent from '../components/TestComponent.vue'

const routes = [
  {
    path: '/',
    name: 'TaskList',
    component: TaskList
  },
  {
    path: '/new',
    name: 'TaskCreate',
    component: TaskForm
  },
  {
    path: '/edit/:id',
    name: 'TaskEdit',
    component: TaskForm,
    props: true
  },
  {
    path: '/test',
    name: 'Test',
    component: TestComponent
  }
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router