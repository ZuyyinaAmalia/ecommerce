import './bootstrap';
import 'preline';
import Swal from 'sweetalert2'

window.Swal = Swal

document.addEventListener('livewire:navigate', () => {
    window.HSStaticMethods.autoInit();
})
