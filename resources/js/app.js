import './bootstrap';
import '../css/app.css';
import 'preline'; // pastikan ini ada

// biar HSStaticMethods global
import { HSStaticMethods } from 'preline';
window.HSStaticMethods = HSStaticMethods;

// untuk Livewire navigasi
document.addEventListener("livewire:navigate", () => {
  setTimeout(() => window.HSStaticMethods?.autoInit(), 50);
});

// untuk initial load
document.addEventListener("DOMContentLoaded", () => {
  setTimeout(() => window.HSStaticMethods?.autoInit(), 50);
});
