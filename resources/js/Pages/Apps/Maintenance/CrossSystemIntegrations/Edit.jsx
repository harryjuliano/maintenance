import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { crossSystemIntegration, users } = usePage().props;

    return <Create initialData={crossSystemIntegration} users={users} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
