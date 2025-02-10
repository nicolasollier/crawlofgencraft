import js from '@eslint/js'
import vue from 'eslint-plugin-vue'
import prettier from 'eslint-config-prettier'

export default [
    {
        ignores: ['dist/**', 'node_modules/**', 'public/**'],
        languageOptions: {
            ecmaVersion: 2020,
            sourceType: 'module',
            parserOptions: {
                ecmaVersion: 2020,
                sourceType: 'module'
            },
            globals: {
                window: 'readonly'
            }
        },
        plugins: {
            'vue': vue
        },
        rules: {
            ...js.configs.recommended.rules,
            ...vue.configs['vue3-recommended'].rules,
            'no-console': process.env.APP_ENV === 'production' ? 'warn' : 'off',
            'no-debugger': process.env.APP_ENV === 'production' ? 'warn' : 'off'
        }
    },
    prettier
]