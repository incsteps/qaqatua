<script lang="ts" setup>
import {router, useForm} from '@inertiajs/vue3'
import Table from '@/components/ui/table/Table.vue';
import TableCaption from '@/components/ui/table/TableCaption.vue';
import TableHead from '@/components/ui/table/TableHead.vue';
import TableRow from '@/components/ui/table/TableRow.vue';
import TableCell from '@/components/ui/table/TableCell.vue';
import TableBody from '@/components/ui/table/TableBody.vue';
import {onMounted, ref} from 'vue';
import TableHeader from '@/components/ui/table/TableHeader.vue';
import Input from '@/components/ui/input/Input.vue';
import {Label} from '@/components/ui/label';
import InputError from '@/components/InputError.vue';
import Button from '@/components/ui/button/Button.vue';
import Card from '@/components/ui/card/Card.vue';
import CardContent from '@/components/ui/card/CardContent.vue';
import CardTitle from '@/components/ui/card/CardTitle.vue';

const projects = ref([])

const loadProjects = async () => {
    const data = await fetch("/resources/projects");
    const json = await data.json();
    projects.value = json.data;
}

const updateFields = async (project) => {
    router.put(route('project.update', {id: project.id}), {
        fields: project.fields,
    })
    await loadProjects();
}

const deleteProject = async (project) => {
    router.delete(route('project.delete', {id: project.id}))
    await loadProjects();
}

const form = useForm({
    name: '',
    fields: '',
    privkey: '',
    pubkey: '',
});
const submit = () => {
    form.post(route('project.create'), {
        onFinish: ()=>{loadProjects()},
        onError: ()=> {}
    });
};


onMounted(async () => {
    await loadProjects();
})
</script>

<template>
    <Table>
        <TableCaption>List of Projects.</TableCaption>
        <TableHeader>
            <TableRow>
                <TableHead>#</TableHead>
                <TableHead>Name</TableHead>
                <TableHead>Created</TableHead>
                <TableHead>Fields</TableHead>
                <TableHead>PrivKey</TableHead>
                <TableHead>PubKey</TableHead>
            </TableRow>
        </TableHeader>
        <TableBody>
            <TableRow v-for="p in projects" key="p.id">
                <TableCell>
                    <Button @click="deleteProject(p)">Delete</Button>
                </TableCell>
                <TableCell>{{ p.name }}</TableCell>
                <TableCell>{{ p.created_at }}</TableCell>
                <TableCell><Input v-model="p.fields"></Input>
                    <Button @click="updateFields(p)">Change</Button>
                </TableCell>
                <TableCell>{{ p.privkey }}</TableCell>
                <TableCell>{{ p.pubkey }}</TableCell>
            </TableRow>
        </TableBody>
    </Table>

    <Card>
        <CardTitle>
            Create a new Project
        </CardTitle>
        <CardContent>
            <form class="flex flex-col gap-6" @submit.prevent="submit">
                <div class="grid">
                    <div class="">
                        <Label for="name">Name</Label>
                        <Input id="name" v-model="form.name" :tabindex="1" autocomplete="name" autofocus
                               placeholder="Project name" required
                               type="text"/>
                        <InputError :message="form.errors.name"/>
                    </div>
                    <div class="">
                        <Label for="fields">Fields</Label>
                        <Input id="fields" v-model="form.fields" :tabindex="2" autocomplete="fields"
                               placeholder="user.password,account"
                               type="text"/>
                        <InputError :message="form.errors.fields"/>
                    </div>
                    <div class="">
                        <Label for="privkey">Private Key (Base64)</Label>
                        <Input id="privkey" v-model="form.privkey" :tabindex="2" autocomplete="privkey" placeholder=""
                               type="text"/>
                        <InputError :message="form.errors.privkey"/>
                    </div>
                    <div class="">
                        <Label for="pubkey">Public Key (Base64)</Label>
                        <Input id="pubkey" v-model="form.pubkey" :tabindex="2" autocomplete="pubkey" placeholder=""
                               type="text"/>
                        <InputError :message="form.errors.pubkey"/>
                    </div>
                    <div class="">
                        <div class="relative space-y-0.5 text-blue-600 dark:text-blue-100">
                            <p class="font-medium">Warning</p>
                            <p class="text-sm">If private or public key are empty, QAQAtua will generate a random key pair.</p>
                        </div>
                    </div>
                </div>
                <div class="grid">
                    <div class="">
                        <Button type="submit">Create</Button>
                    </div>
                </div>
            </form>
        </CardContent>
    </Card>
</template>

<style scoped>

</style>

