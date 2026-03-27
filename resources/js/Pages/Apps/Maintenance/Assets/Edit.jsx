import AppLayout from '@/Layouts/AppLayout';
import Create from './Create';
import { usePage } from '@inertiajs/react';

export default function Edit() {
    const { asset } = usePage().props;
    return <Create key={asset.id} initialData={asset} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
