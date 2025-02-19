import { defineStore } from "pinia";

export const useDungeonStore = defineStore("dungeon", {
    state: () => ({
        isInitialized: false,
        isLoading: true,
        dungeons: [],
        currentDungeon: null,
    }),

    getters: {
        hasDungeons: (state) => state.dungeons.length > 0,
    },

    actions: {
        initializeStore(dungeons) {
            this.isLoading = true;
            this.dungeons = dungeons;
            if (this.hasDungeons && !this.currentDungeon) {
                this.setCurrentDungeon(dungeons[0]);
            }
            this.isInitialized = true;
            this.isLoading = false;
        },

        setCurrentDungeon(dungeon) {
            this.isLoading = true;
            this.currentDungeon = dungeon;
            this.isLoading = false;
        },

        addDungeon(dungeon) {
            this.isLoading = true;
            this.dungeons.push(dungeon);
            this.isLoading = false;
        },

        removeDungeon(dungeonId) {
            this.isLoading = true;
            this.dungeons = this.dungeons.filter(d => d.id !== dungeonId);
            if (this.currentDungeon && this.currentDungeon.id === dungeonId) {
                this.currentDungeon = null;
            }
            this.isLoading = false;
        }
    },
}, {
    persist: true
});
