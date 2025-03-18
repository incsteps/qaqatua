import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'

export default defineUserConfig({
    bundler: viteBundler(),
    theme: defaultTheme({
        navbar: [
            {
                text: 'Qaqatua',
                link: '../',
            },
        ],
        locales: {
            '/': {
                selectLanguageName: 'English',
            },
            '/es/': {
                selectLanguageName: 'Español',
            }
        }
    }),

    base: '/documentation/',

    dest: `./public/documentation`,

    head: [['link', { rel: 'icon', href: '/qaqatua.png' }]],

    locales: {
        // The key is the path for the locale to be nested under.
        // As a special case, the default locale can use '/' as its path.
        '/': {
            lang: 'en-US',
            title: 'Qaqatua',
            description: 'An enc/dec echo server, usefully for QA testing',
        },
        '/es/': {
            lang: 'es-ES',
            title: 'Qaqatua',
            description: 'Encripta y desencripta payloads en tu pruebas',
        },
    },
})
