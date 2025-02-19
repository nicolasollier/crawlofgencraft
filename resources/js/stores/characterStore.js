import { defineStore } from "pinia";

export const useCharacterStore = defineStore("character", {
    state: () => ({
        isInitialized: false,
        isLoading: true,
        characters: [],
        currentCharacter: null,
    }),

    getters: {
        hasCharacters: (state) => state.characters.length > 0,
        inventory: (state) =>
            state.currentCharacter?.inventory.map((entry) => entry.item) || [],
    },

    actions: {
        initializeStore(characters) {
            this.isLoading = true;
            this.setCharacters(characters);
            this.isInitialized = true;
            this.isLoading = false;
        },
        
        setCharacters(characters) {
            if (!characters || characters.length === 0) {
                this.isLoading = false;
                return;
            }
            
            this.characters = characters;
            this.currentCharacter = this.currentCharacter
                ? characters.find(c => c.id === this.currentCharacter.id) || characters[0]
                : characters[0];
            this.isInitialized = true;
            this.isLoading = false;
        },

        setCurrentCharacter(character) {
            this.isLoading = true;
            this.currentCharacter = character;
            this.isLoading = false;
        },
    },
}, {
    persist: true
});