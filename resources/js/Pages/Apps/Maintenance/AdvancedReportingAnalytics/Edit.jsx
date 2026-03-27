import AppLayout from '@/Layouts/AppLayout';
import { usePage } from '@inertiajs/react';
import Create from './Create';

export default function Edit() {
    const { advancedReportingAnalytic, users } = usePage().props;

    return <Create initialData={advancedReportingAnalytic} users={users} isEdit />;
}

Edit.layout = (page) => <AppLayout children={page} />;
