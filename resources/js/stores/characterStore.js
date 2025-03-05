import { ref, computed } from 'vue'
import { defineStore } from 'pinia'

export const useCharacterStore = defineStore('character', () => {
    const isInitialized = ref(false)
    const isLoading = ref(true)
    const characters = ref([])
    const currentCharacter = ref(null)

    const hasCharacters = computed(() => characters.value.length > 0)
    const inventory = computed(() =>
        currentCharacter.value?.inventory.map((entry) => {
            return {
                ...entry.item,
                inventory_id: entry.id,
                equipped: entry.equipped
            }
        }) || []
    )

    function initializeStore(newCharacters) {
        isLoading.value = true
        setCharacters(newCharacters)
        isInitialized.value = true
        isLoading.value = false
    }

    function setCharacters(newCharacters) {
        if (!newCharacters || newCharacters.length === 0) {
            isLoading.value = false
            return
        }

        characters.value = newCharacters
        currentCharacter.value = currentCharacter.value
            ? newCharacters.find(c => c.id === currentCharacter.value.id) || newCharacters[0]
            : newCharacters[0]
        isInitialized.value = true
        isLoading.value = false
    }

    function setCurrentCharacter(character) {
        isLoading.value = true
        currentCharacter.value = character
        isLoading.value = false
    }

    function resetStore() {
        isInitialized.value = false
        isLoading.value = true
        characters.value = []
        currentCharacter.value = null
    }

    return {
        isInitialized,
        isLoading,
        characters,
        currentCharacter,
        hasCharacters,
        inventory,
        initializeStore,
        setCharacters,
        setCurrentCharacter,
        resetStore
    }
}, {
    persist: true
})