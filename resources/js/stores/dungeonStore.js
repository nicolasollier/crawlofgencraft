import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useDungeonStore = defineStore('dungeon', () => {
    const isInitialized = ref(false)
    const isLoading = ref(true)
    const dungeons = ref([])
    const currentDungeon = ref(null)

    const hasDungeons = computed(() => dungeons.value.length > 0)

    function initializeStore(newDungeons) {
        isLoading.value = true
        dungeons.value = newDungeons
        if (hasDungeons.value && !currentDungeon.value) {
            setCurrentDungeon(newDungeons[0])
        }
        isInitialized.value = true
        isLoading.value = false
    }

    function setCurrentDungeon(dungeon) {
        isLoading.value = true
        currentDungeon.value = dungeon
        isLoading.value = false
    }

    function addDungeon(dungeon) {
        isLoading.value = true
        dungeons.value.push(dungeon)
        isLoading.value = false
    }

    function removeDungeon(dungeonId) {
        isLoading.value = true
        dungeons.value = dungeons.value.filter(d => d.id !== dungeonId)
        if (currentDungeon.value && currentDungeon.value.id === dungeonId) {
            currentDungeon.value = null
        }
        isLoading.value = false
    }

    return {
        isInitialized,
        isLoading,
        dungeons,
        currentDungeon,
        hasDungeons,
        initializeStore,
        setCurrentDungeon,
        addDungeon,
        removeDungeon
    }
}, {
    persist: true
})
