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
            if (this.hasDungeons && !this.currentDungeon) {
                this.setCurrentDungeon(dungeons[0]);
            }
        },

        setCurrentDungeon(dungeon) {
            this.currentDungeon = dungeon;
        },

        addDungeon(dungeon) {
            this.dungeons.push(dungeon);
        },

        removeDungeon(dungeonId) {
            this.dungeons = this.dungeons.filter(d => d.id !== dungeonId);
            if (this.currentDungeon && this.currentDungeon.id === dungeonId) {
                this.currentDungeon = null;
            }
        }
    },
});
