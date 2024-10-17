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
            if (characters.length > 0 && !this.currentCharacter) {
                this.setCurrentCharacter(characters[0]);
            }
        },

        setCurrentCharacter(character) {
            this.currentCharacter = character;
        },
    },
});
