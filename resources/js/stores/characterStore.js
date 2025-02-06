import { defineStore } from "pinia";

export const useCharacterStore = defineStore("character", {
    state: () => ({
        characters: [],
        currentCharacter: null,
    }),

    getters: {
        hasCharacters: (state) => state.characters.length > 0,
        inventory: (state) =>
            state.currentCharacter?.inventory.map((entry) => entry.item) || [],
    },

    actions: {
        setCharacters(characters) {
            this.characters = characters;
            this.currentCharacter = this.currentCharacter
                ? characters.find(c => c.id === this.currentCharacter.id) || characters[0]
                : characters[0] || null;
        },

        setCurrentCharacter(character) {
            this.currentCharacter = character;
        },
    },
});
