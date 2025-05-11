<template>
    <div class="flex justify-center items-center py-4">
        <svg class="animate-spin h-6 w-6 text-slate-400"
             xmlns="http://www.w3.org/2000/svg"
             fill="none"
             viewBox="0 0 24 24">
            <circle class="opacity-25"
                    cx="12"
                    cy="12"
                    r="10"
                    stroke="currentColor"
                    stroke-width="4" />
            <path class="opacity-75"
                  fill="currentColor"
                  d="M4 12a8 8 0 018-8v8z" />
        </svg>
        <span class="ml-2 text-sm text-slate-400">Loading...</span>
    </div>
</template>

<script setup>
</script>