import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { notification, users } = usePage().props;

    return <Create initialData={notification} users={users} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
