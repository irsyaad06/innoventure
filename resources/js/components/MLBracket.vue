<template>
    <div class="flex items-center justify-center p-10 bg-gray-900">
        <a
            href="https://challonge.com/id/mlbbinnoventure2025"
            target="_blank"
            rel="noopener noreferrer"
            class="
                relative inline-flex items-center justify-center gap-3 px-8 py-4
                text-lg font-bold text-white
                bg-gradient-to-r from-cyan-500 to-blue-600
                rounded-xl shadow-lg
                transition-all duration-300 ease-in-out
                transform hover:scale-105 hover:shadow-2xl hover:shadow-cyan-500/50
                focus:outline-none focus:ring-4 focus:ring-cyan-300
            "
        >
            <i class="fas fa-sitemap"></i>
            <span>Lihat Bracket</span>
        </a>
    </div>
</template>

<script>
export default {
    name: 'BracketButtonElegant'
}
</script>