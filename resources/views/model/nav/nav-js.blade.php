<script>


    document.getElementById('openSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.remove('-translate-x-full');
        document.getElementById('mobileSidebarOverlay').classList.remove('hidden');
    });

    document.getElementById('closeSidebar').addEventListener('click', function() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        document.getElementById('mobileSidebarOverlay').classList.add('hidden');
    });

    document.getElementById('mobileSidebarOverlay').addEventListener('click', function() {
        document.getElementById('sidebar').classList.add('-translate-x-full');
        this.classList.add('hidden');
    });

    document.addEventListener("DOMContentLoaded", function() {
        const user = JSON.parse(localStorage.getItem('userData'));
        if (user && user.name) {
            document.getElementById('userName').textContent = user.name;
        }
    });
</script>