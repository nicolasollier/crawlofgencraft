import { defineStore } from "pinia";

export const useDungeonStore = defineStore("dungeon", {
    state: () => ({
        dungeons: [],
        currentDungeon: null,
    }),

    getters: {
        hasDungeons: (state) => state.dungeons.length > 0,
    },

    actions: {
        setDungeons(dungeons) {
            this.dungeons = dungeons;
            if (dungeons.length > 0 && !this.currentDungeon) {
                this.setCurrentDungeon(dungeons[0]);
            }
        },

        setCurrentDungeon(dungeon) {
            this.currentDungeon = dungeon;
        },
    },
});
