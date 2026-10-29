import { Form, Head } from '@inertiajs/react';
import { Eye, EyeOff, Lock, User } from 'lucide-react';
import { useState } from 'react';
import InputError from '@/components/input-error';
import { Button } from '@/components/ui/button';
import { Checkbox } from '@/components/ui/checkbox';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Spinner } from '@/components/ui/spinner';
import { store } from '@/routes/login';

type Props = {
    status?: string;
};

export default function Login({ status }: Props) {
    // true = password is shown as plain text
    const [showPassword, setShowPassword] = useState(false);

    return (
        <>
            <Head title="Log in" />

            {status && (
                <div className="mb-5 rounded-lg border border-green-600/25 bg-green-600/10 px-3.5 py-2.5 text-sm font-medium text-green-700 dark:text-green-400">
                    {status}
                </div>
            )}

            <Form
                {...store.form()}
                resetOnSuccess={['password']}
                className="flex flex-col gap-5"
            >
                {({ processing, errors }) => (
                    <>
                        <div className="grid gap-2">
                            <Label htmlFor="employee_no">Employee No.</Label>
                            <div className="relative">
                                <User
                                    aria-hidden
                                    className="pointer-events-none absolute top-1/2 left-3.5 size-[18px] -translate-y-1/2 text-muted-foreground"
                                />
                                <Input
                                    id="employee_no"
                                    type="text"
                                    name="employee_no"
                                    required
                                    autoFocus
                                    tabIndex={1}
                                    autoComplete="username"
                                    placeholder="Enter your employee number"
                                    className="h-11 pl-10"
                                />
                            </div>
                            <InputError message={errors.employee_no} />
                        </div>

                        <div className="grid gap-2">
                            <Label htmlFor="password">Password</Label>
                            <div className="relative">
                                <Lock
                                    aria-hidden
                                    className="pointer-events-none absolute top-1/2 left-3.5 size-[18px] -translate-y-1/2 text-muted-foreground"
                                />
                                <Input
                                    id="password"
                                    type={showPassword ? 'text' : 'password'}
                                    name="password"
                                    required
                                    tabIndex={2}
                                    autoComplete="current-password"
                                    placeholder="Enter your password"
                                    className="h-11 pr-11 pl-10"
                                />
                                <button
                                    type="button"
                                    // keep the cursor in the password box when clicking the eye
                                    onMouseDown={(e) => e.preventDefault()}
                                    onClick={() =>
                                        setShowPassword((current) => !current)
                                    }
                                    aria-label={
                                        showPassword
                                            ? 'Hide password'
                                            : 'Show password'
                                    }
                                    aria-pressed={showPassword}
                                    className="absolute inset-y-0 right-0 grid w-11 place-items-center rounded-r-md text-muted-foreground hover:text-foreground"
                                >
                                    {showPassword ? (
                                        <EyeOff
                                            className="size-[18px]"
                                            aria-hidden
                                        />
                                    ) : (
                                        <Eye
                                            className="size-[18px]"
                                            aria-hidden
                                        />
                                    )}
                                </button>
                            </div>
                            <InputError message={errors.password} />
                        </div>

                        <div className="flex items-center space-x-3">
                            <Checkbox
                                id="remember"
                                name="remember"
                                tabIndex={3}
                            />
                            <Label
                                htmlFor="remember"
                                className="font-normal text-muted-foreground"
                            >
                                Keep me signed in
                            </Label>
                        </div>

                        <Button
                            type="submit"
                            className="mt-1 h-12 w-full bg-[#0f8a3e] text-base text-white shadow-lg shadow-[#0f8a3e]/30 hover:bg-[#0b7a35]"
                            tabIndex={4}
                            disabled={processing}
                            data-test="login-button"
                        >
                            {processing && <Spinner />}
                            Log in
                        </Button>
                    </>
                )}
            </Form>
        </>
    );
}

Login.layout = {
    title: 'Welcome back',
    description: 'Log in with your employee number to manage warehouse inventory.',
};