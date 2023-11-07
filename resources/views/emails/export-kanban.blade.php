{{ '<'.'?'.'xml version="1.0" encoding="UTF-8"?>' }}
{{'<kanban>'}}
    @if($kanban->sections->count())
        {{'<sections>'}}
            @foreach($kanban->sections as $section)
                {{'<section>'}}
                    {{'<name>' . $section->name . '</name>'}}
                        @if($section->notes->count())
                            {{'<notes>'}}
                                @foreach($section->notes as $note)
                                    {{'<note>'}}
                                        {{'<name> ' . $note->name . '</name>'}}
                                        {{'<description> ' . $note->description . '</description>'}}
                                        {{'<deadline> ' . $note->deadline_at . '</deadline>'}}
                                        @if($note->comments->count())
                                            {{'<comments>'}}
                                                @foreach($note->comments as $comment)
                                                    {{'<comment>'}}
                                                        {{'<text> ' . $comment->text . '</text>'}}
                                                    {{'</comment>'}}
                                                @endforeach
                                            {{'</comments>'}}
                                            @endif
                                    {{'</note>'}}
                                @endforeach
                            {{'</notes>'}}
                        @endif
                {{'</section>'}}
            @endforeach
        {{'</sections>'}}
    @endif
{{'</kanban>'}}
