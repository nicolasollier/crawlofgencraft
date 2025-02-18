import { defineStore } from "pinia";

export const useCharacterStore = defineStore("character", {
    state: () => ({
        isInitialized: false,
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
            this.setCharacters(characters);
            this.isInitialized = true;
        },
        setCharacters(characters) {
            if (!characters || characters.length === 0) return;
            
            this.characters = characters;
            this.currentCharacter = this.currentCharacter
                ? characters.find(c => c.id === this.currentCharacter.id) || characters[0]
                : characters[0];
            this.isInitialized = true;
        },

        setCurrentCharacter(character) {
            this.currentCharacter = character;
        },
    },
}, {
    persist: true
});
