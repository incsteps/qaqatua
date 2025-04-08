import { viteBundler } from '@vuepress/bundler-vite'
import { defaultTheme } from '@vuepress/theme-default'
import { defineUserConfig } from 'vuepress'

export default defineUserConfig({
    bundler: viteBundler(),
    theme: defaultTheme({
        navbar: [
            {
                text: 'Qaqatua',
                link: 'https://qaqatua.com/',
            },
            {
                text: 'OpenSource',
                link: 'https://github.com/incsteps/qaqatua',
            },
        ],
        locales: {
            '/': {
                selectLanguageName: 'English',
                sidebar: [
                    {
                        text: "Welcome",
                        link: "/",
                        icon: "lightbulb",
                    },
                    {
                        text: "Guide",
                        link: "/guide",
                        icon: "config"
                    },
                    {
                        text: "Reference",
                        link: "#",
                        icon: "config",
                        children:[
                            {
                                text: "Projects",
                                link: "/projects",
                                icon: "project"
                            },
                            {
                                text: "Fields",
                                link: "/fields",
                                icon: "fields"
                            },
                            {
                                text: "Encrypt",
                                link: "/encrypt",
                                icon: "key"
                            },
                            {
                                text: "Decrypt",
                                link: "/decrypt",
                                icon: "key"
                            },
                        ]
                    },
                ]
            },
            '/es/': {
                selectLanguageName: 'Español',
                sidebar: [
                    {
                        text: "Bienvenido",
                        link: "/es/",
                        icon: "lightbulb",
                    },
                    {
                        text: "Guia",
                        link: "/es/guide",
                        icon: "config"
                    },
                    {
                        text: "Referencia",
                        link: "#",
                        icon: "config",
                        children:[
                            {
                                text: "Projects",
                                link: "/es/projects",
                                icon: "project"
                            },
                            {
                                text: "Fields",
                                link: "/es/fields",
                                icon: "fields"
                            },
                            {
                                text: "Encrypt",
                                link: "/es/encrypt",
                                icon: "key"
                            },
                            {
                                text: "Decrypt",
                                link: "/es/decrypt",
                                icon: "key"
                            },
                        ]
                    },
                ],
            },
        },

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
