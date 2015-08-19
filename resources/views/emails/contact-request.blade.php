@extends('layouts.email')

@section('body')
    <table>
        <tr>
            <td>
                <h2>A new contact request was made on upstatephp.com</h2>
                <p>
                    Someone wants to know about <strong>{!! $subject !!}</strong>
                </p>
                <p>
                    <strong>Name:</strong> {!! $name !!}
                </p>
                <p>
                    <strong>Email:</strong> {!! $email !!}
                </p>
                <p>
                    <strong>Comments:</strong> {!! $comments or '[no comments provided]' !!}
                </p>
            </td>
        </tr>
    </table>
@stop
