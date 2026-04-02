function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
}

function showTab(n) {
    document.querySelectorAll('.tab-content').forEach(t => t.classList.add('hidden'));
    document.getElementById('tab-' + n).classList.remove('hidden');
    
    document.querySelectorAll('.nav-item').forEach((item, i) => {
        item.classList.toggle('active', i === n);
    });
}

function showAddModal() {
    document.getElementById('addModal').classList.remove('hidden');
}

function hideModal(id) {
    document.getElementById(id).classList.add('hidden');
}

function deleteSite(id) {
    if (confirm('Видалити сайт та всі пов’язані дані?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.innerHTML = `<input type="hidden" name="action" value="delete_site"><input type="hidden" name="id" value="${id}">`;
        document.body.appendChild(form);
        form.submit();
    }
}

function editSite(siteJson) {
    const site = JSON.parse(siteJson);
    const html = `
        <div class="bg-zinc-900 rounded-3xl p-10 w-full max-w-lg">
            <h3 class="text-2xl font-bold mb-6">Редагувати сайт</h3>
            <form method="POST">
                <input type="hidden" name="action" value="edit_site">
                <input type="hidden" name="id" value="${site.id}">
                <input type="text" name="name" value="${site.name}" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 mb-4">
                <input type="text" name="domain" value="${site.domain}" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 mb-4">
                <textarea name="description" class="w-full bg-zinc-800 border border-zinc-700 rounded-2xl px-6 py-4 mb-6" rows="3">${site.description || ''}</textarea>
                <div class="flex gap-4">
                    <button type="button" onclick="hideModal('editModal')" class="flex-1 py-4 bg-zinc-800 rounded-2xl">Скасувати</button>
                    <button type="submit" class="flex-1 py-4 bg-sky-600 rounded-2xl font-semibold">Зберегти</button>
                </div>
            </form>
        </div>`;
    document.getElementById('editModal').innerHTML = html;
    document.getElementById('editModal').classList.remove('hidden');
}

function checkConnection(id) {
    const form = document.createElement('form');
    form.method = 'POST';
    form.innerHTML = `<input type="hidden" name="action" value="check_connection"><input type="hidden" name="id" value="${id}">`;
    document.body.appendChild(form);
    form.submit();
}

function copyCode(btn) {
    const code = btn.previousElementSibling.textContent.trim();
    navigator.clipboard.writeText(code);
    btn.textContent = 'Скопійовано!';
    setTimeout(() => btn.textContent = 'Копіювати код', 2000);
}

// Ініціалізація
document.addEventListener('DOMContentLoaded', () => {
    showTab(0);
});
