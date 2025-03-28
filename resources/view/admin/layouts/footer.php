</div>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    
    // فعال و غیرفعال کردن منوی سایدبار با کلیک روی دکمه همبرگر
    document.getElementById('sidebarToggle').addEventListener('click', function() {
        document.querySelector('.sidebar').classList.toggle('active');
    });

    // منوی کشویی
    document.querySelectorAll('.toggle-menu').forEach(item => {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            let parent = this.parentElement;
            parent.classList.toggle('active');
        });
    });
</script>
</body>
</html>
