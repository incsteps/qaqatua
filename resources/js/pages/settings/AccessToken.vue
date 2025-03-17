<script setup lang="ts">
import { Head, useForm, usePage } from '@inertiajs/vue3';

import HeadingSmall from '@/components/HeadingSmall.vue';
import InputError from '@/components/InputError.vue';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import AppLayout from '@/layouts/AppLayout.vue';
import SettingsLayout from '@/layouts/settings/Layout.vue';
import { type BreadcrumbItem, type SharedData, type User } from '@/types';
import {
    Dialog, DialogClose,
    DialogContent,
    DialogDescription, DialogFooter,
    DialogHeader,
    DialogTitle,
} from '@/components/ui/dialog';
import {ref} from 'vue';

interface Props {
    tokens?: array;
    flash?: object;
}

defineProps<Props>();

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Access token',
        href: '/settings/accesstoken',
    },
];

const page = usePage<SharedData>();
const user = page.props.auth.user as User;

const form = useForm({
    name: user.name,
});

const submit = () => {
    form.put(route('accesstoken.generate'), {
        preserveScroll: true,
    });
};

</script>

<template>
    <AppLayout :breadcrumbs="breadcrumbs">
        <Head title="Access Token" />

        <SettingsLayout>
            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Access Token List" description="Update your access tokens" />
                <Table>
                    <thead>
                    <tr>
                        <th class="text-left">
                            Name
                        </th>
                        <th class="text-left">
                            Roles
                        </th>
                        <th class="text-left">
                            Created
                        </th>
                        <th class="text-left">
                            Expired
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr
                        v-for="item in tokens"
                        :key="item.id">
                        <td>{{ item.name }}</td>
                        <td>{{ item.abilities }}</td>
                        <td>{{ item.created_at }}</td>
                        <td>{{ item.expired_at }}</td>
                    </tr>
                    </tbody>
                </Table>
            </div>

            <div class="flex flex-col space-y-6">
                <HeadingSmall title="Access token" description="Create a new token" />

                <form @submit.prevent="submit" class="space-y-6">
                    <div class="grid gap-2">
                        <Label for="name">Name</Label>
                        <Input id="name" class="mt-1 block w-full" v-model="form.name" required autocomplete="name" placeholder="Full name" />
                        <InputError class="mt-2" :message="form.errors.name" />
                    </div>

                    <div class="flex items-center gap-4">
                        <Button :disabled="form.processing">Save</Button>

                        <Transition
                            enter-active-class="transition ease-in-out"
                            enter-from-class="opacity-0"
                            leave-active-class="transition ease-in-out"
                            leave-to-class="opacity-0"
                        >
                            <p v-show="form.recentlySuccessful" class="text-sm text-neutral-600">Saved.</p>
                        </Transition>
                    </div>
                </form>
            </div>

            <div v-if="page.props.flash.message" class="space-y-4 rounded-lg border border-red-100 bg-red-50 p-4 dark:border-red-200/10 dark:bg-red-700/10">
                <div class="relative space-y-0.5 text-red-600 dark:text-red-100">
                    <p class="font-medium">Warning</p>
                    <p class="text-sm">Grab your token as it will not be revealed anymore.</p>
                </div>
                {{page.props.flash.message}}
            </div>


        </SettingsLayout>
    </AppLayout>
</template>
